   <div class="tab-pane" id="backup" role="tabpanel">
       <div class="mb-3">
           <table>
               <thead>
                   <tr>
                       <th>Nom du fichier</th>
                       <th>Actions</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($backup as $file)
                       <tr>
                           <td>{{ basename($file) }}</td>
                           <td>
                               <a href="{{ route('setting.download-backup', basename($file)) }}">Télécharger <i
                                       class="ri-download-line align-bottom"></i></a>
                           </td>
                       </tr>
                   @endforeach
               </tbody>
           </table>

       </div>


   </div>
