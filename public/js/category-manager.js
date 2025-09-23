// Fonctionnalités avancées pour la gestion des catégories
class CategoryManager {
    constructor() {
        this.initializeDragAndDrop();
        this.initializeInlineEditing();
        this.initializeKeyboardShortcuts();
    }

    // Initialisation du drag & drop pour réorganiser
    initializeDragAndDrop() {
        if (typeof Sortable !== 'undefined') {
            const categoryTrees = document.querySelectorAll('.category-tree, .category-children');
            
            categoryTrees.forEach(tree => {
                new Sortable(tree, {
                    group: 'categories',
                    animation: 200,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    handle: '.category-info',
                    onEnd: (evt) => {
                        this.updateCategoryOrder(evt);
                    }
                });
            });
        }
    }

    // Mise à jour de l'ordre des catégories
    updateCategoryOrder(evt) {
        const categoryId = evt.item.dataset.categoryId;
        const newParentId = evt.to.closest('.category-item')?.dataset.categoryId || null;
        const newPosition = evt.newIndex + 1;

        // Afficher un indicateur de chargement
        this.showLoadingIndicator();

        fetch('/admin/categorie/reorder', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                category_id: categoryId,
                parent_id: newParentId,
                position: newPosition
            })
        })
        .then(response => response.json())
        .then(data => {
            this.hideLoadingIndicator();
            if (data.success) {
                this.showNotification('Ordre mis à jour avec succès', 'success');
            } else {
                this.showNotification('Erreur lors de la mise à jour', 'error');
                // Recharger la page en cas d'erreur
                location.reload();
            }
        })
        .catch(error => {
            this.hideLoadingIndicator();
            this.showNotification('Erreur de connexion', 'error');
            location.reload();
        });
    }

    // Initialisation de l'édition en ligne
    initializeInlineEditing() {
        document.addEventListener('dblclick', (e) => {
            const categoryName = e.target.closest('.category-name');
            if (categoryName && !categoryName.querySelector('input')) {
                this.enableInlineEdit(categoryName);
            }
        });
    }

    // Activer l'édition en ligne
    enableInlineEdit(categoryNameElement) {
        const originalText = categoryNameElement.textContent.trim();
        const categoryId = categoryNameElement.closest('.category-item').dataset.categoryId;
        
        const input = document.createElement('input');
        input.type = 'text';
        input.value = originalText;
        input.className = 'form-control form-control-sm';
        input.style.minWidth = '150px';
        
        categoryNameElement.innerHTML = '';
        categoryNameElement.appendChild(input);
        input.focus();
        input.select();

        const saveEdit = () => {
            const newName = input.value.trim();
            if (newName && newName !== originalText) {
                this.saveCategoryName(categoryId, newName, categoryNameElement, originalText);
            } else {
                categoryNameElement.textContent = originalText;
            }
        };

        const cancelEdit = () => {
            categoryNameElement.textContent = originalText;
        };

        input.addEventListener('blur', saveEdit);
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                saveEdit();
            } else if (e.key === 'Escape') {
                e.preventDefault();
                cancelEdit();
            }
        });
    }

    // Sauvegarder le nom de catégorie modifié
    saveCategoryName(categoryId, newName, categoryNameElement, originalText) {
        this.showLoadingIndicator();

        fetch(`/admin/categorie/quick-update/${categoryId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: newName
            })
        })
        .then(response => response.json())
        .then(data => {
            this.hideLoadingIndicator();
            if (data.success) {
                categoryNameElement.textContent = newName;
                this.showNotification('Nom mis à jour avec succès', 'success');
            } else {
                categoryNameElement.textContent = originalText;
                this.showNotification(data.message || 'Erreur lors de la mise à jour', 'error');
            }
        })
        .catch(error => {
            this.hideLoadingIndicator();
            categoryNameElement.textContent = originalText;
            this.showNotification('Erreur de connexion', 'error');
        });
    }

    // Initialisation des raccourcis clavier
    initializeKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + N : Nouvelle catégorie
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                document.querySelector('#category_name')?.focus();
            }
            
            // Ctrl/Cmd + E : Développer tout
            if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                e.preventDefault();
                document.querySelector('#expandAll')?.click();
            }
            
            // Ctrl/Cmd + R : Réduire tout
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                document.querySelector('#collapseAll')?.click();
            }
        });
    }

    // Afficher un indicateur de chargement
    showLoadingIndicator() {
        const loader = document.createElement('div');
        loader.id = 'category-loader';
        loader.className = 'position-fixed top-50 start-50 translate-middle';
        loader.style.zIndex = '9999';
        loader.innerHTML = `
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        `;
        document.body.appendChild(loader);
    }

    // Masquer l'indicateur de chargement
    hideLoadingIndicator() {
        const loader = document.getElementById('category-loader');
        if (loader) {
            loader.remove();
        }
    }

    // Afficher une notification
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-masquer après 3 secondes
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// Initialiser le gestionnaire de catégories une fois le DOM chargé
document.addEventListener('DOMContentLoaded', function() {
    new CategoryManager();
});

// Styles CSS pour le drag & drop
const dragDropStyles = `
<style>
    .sortable-ghost {
        opacity: 0.4;
        background-color: #e3f2fd;
        border: 2px dashed #2196f3;
    }
    
    .sortable-chosen {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .sortable-drag {
        transform: rotate(5deg);
    }
    
    .category-item {
        transition: all 0.3s ease;
    }
    
    .category-item:hover {
        transform: translateY(-1px);
    }
    
    .inline-edit-mode {
        background-color: #fff3cd;
        border-color: #ffc107;
    }
</style>
`;

// Ajouter les styles au head
document.head.insertAdjacentHTML('beforeend', dragDropStyles);