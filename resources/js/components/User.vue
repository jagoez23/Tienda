<template>
    <div>
        <h1 class="text-center">Lista de Usuarios</h1>
        <hr/>

        <!-- Button trigger modal -->
        <button @click="update=false;  openModal();" type="button" class="btn btn-primary my-4">
        Nuevo Usuario
        </button>
        
        <!-- Modal -->
        <div class="modal" :class="{mostrar:modal}">
        <div class="modal-dialog">
            <div class="modal-content">
                 <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">{{titleModal}}</h5>
                <button @click="closeModal();" type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
             <!-- Modal body -->
            <div class="modal-body">
                <div class="my-4">
                    <label for="name">Nombre</label>
                    <input v-model="user.name" type="text" class="form-control" id="name" placeholder="Nombre del Usuario" name=""  >
                    <span class="text-danger" v-if="errores.name">{{errores.name[0]}}</span>
                </div>
                <div class="my-4">
                    <label for="email">Correo Electrónico</label>
                    <input v-model="user.email" type="text" class="form-control" id="email" placeholder="Correo Electrónico" name=""  >
                    <span class="text-danger" v-if="errores.email">{{errores.email[0]}}</span>
                </div>
                <div class="my-4">
                     <label for="active_user">Estado Usuario</label>
                     <select name="active_user" v-model="user.active_user">
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                     </select>   
                </div>
            </div>
             <!-- Modal footer --> 
            <div class="modal-footer">
                <button @click="closeModal();" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button @click="save();" type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
            </div>
            </div>
        </div>
        </div>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col" colspan="2" class="text-center">Acción</th>  
                </tr>
            </thead>
            <tbody>
                <tr v-for="user  in users" :key="user.id">
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>
                    <button @click="update=true; openModal(user);" class="btn btn-warning">Editar</button>  
                </td>
                <td>
                    <button @click="eliminar(user.id)" class="btn btn-danger">Eliminar</button>  
                </td>
                </tr> 
            </tbody>
        </table>

        <div class="row">
            <div class="col-3 md-3 text-aling-right text-primary">
                {{users.from}} - {{users.to}} /total:{{users.total}}
            </div>
            <div class="col-2 md-2">
                <select class="form-select" v-model="pagination.per_page" @change="list();">
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="6">6</option>
                </select>
            </div>  

            <div class="col-7 md-7">
                <nav>
                    <ul class="pagination">
                        <li class="page-item" :class="{disabled:pagination.page==1}"><a href="#" class="page-link" @click="pagination.page=1; list()">&laquo;</a></li>
                        <li class="page-item" :class="{disabled:pagination.page==1}"><a href="#" class="page-link" @click="pagination.page--; list()">&lt;</a></li>
                        <li class="page-item" v-for="n in pages" :key="n"  :class="{active:pagination.page==n}"><a href="#" class="page-link" @click="pagination.page=n; list()">{{n}}</a></li>
                        <li class="page-item" :class="{disabled:pagination.page==users.last_page}"><a href="#" class="page-link" @click="pagination.page++; list()">&gt;</a></li>
                        <li class="page-item" :class="{disabled:pagination.page==users.last_page}"><a href="#" class="page-link" @click="pagination.page=users.last_page; list()">&raquo;</a></li>
                    </ul>
                </nav>
            </div>    
        </div>  
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    nombre:'',
                    correo:'',
                    active_user:'',
                },
                id:0,
                update:true,
                modal:0,
                titleModal:'',
                users:[],
                errores:{},
                pagination:{
                    page:1,
                    per_page:5,
                },
                pages:[], 
            };
        },
        methods: {
            async list() {
                const res = await axios.get('/api/user',{params:this.pagination});
                this.users = res.data;
                this.listPage();
            },
            listPage() {
              const n = 2
              let arrayN=[]
              let ini = this.pagination.page - 2
              if(ini<1){
                  ini = 1
              }
              let fin = this.pagination.page + 2
              if(fin>this.users.last_page){
                 fin=this.users.last_page
              }
              for(let i = ini; i <= fin; i++ ) {
                  arrayN.push(i)
                }
                this.pages = arrayN   
            },
            async eliminar(id) {
                const res = await axios.delete('api/user/'+id);
                this.list();

            },
            async save() {
              try{  
                    if(this.update){
                    const res = await axios.put('api/user/' +this.id, this.user);
                    }else{
                        const res = await axios.post('api/user/', this.user);
                    }
                    this.closeModal();
                    this.list();
                } catch(error){
                    if(error.response.data){
                      this.errores = error.response.data.errors
                  }    
                }     
            },
            openModal(data={}){
                this.modal=1;
                if(this.update) {
                    this.id = data.id;
                    this.titleModal="Modificar Usuario";
                    this.user.name = data.name;
                    this.user.email = data.email;
                    this.user.active_user = data.active_user;
                }else{
                    this.id = 0;
                    this.titleModal="Crear Usuario";
                    this.user.name = '';
                    this.user.email = '';
                    this.user.active_user = '';
                }
            },
            closeModal(){
                this.modal=0;
            },      
        },
        created() {
            this.list();
        },
    };
</script>

<style>
    .mostrar {
  display: list-item;
  opacity: 1;
  background: rgba(75, 56, 143, 0.705);
}
</style>