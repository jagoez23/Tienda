<template>
    <div>
        <h1 class="text-center">Lista de Productos</h1>
        <hr/>

         <!-- Button trigger modal -->
        <button @click="update=false;  openModal();" type="button" class="btn btn-primary my-4">
        Nuevo Producto
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
                <form @submit="addProduct" enctype="multipart/form-data">
                    <div class="my-4">
                        <label for="name">Nombre</label>
                        <input v-model="product.name" type="text" class="form-control" id="name" placeholder="Nombre del producto" name=""  >
                        <span class="text-danger" v-if="errores.name">{{errores.name[0]}}</span>
                    </div>
                    <div class="my-4">
                        <label for="description">Descripción</label>
                        <input v-model="product.description" type="text" class="form-control" id="description" placeholder="Descripción del producto" name=""  >
                        <span class="text-danger" v-if="errores.description">{{errores.description[0]}}</span>
                    </div>
                    <div class="my-4">
                        <label for="price">Precio</label>
                        <input v-model="product.price" type="text" class="form-control" id="price" placeholder="Precio del producto" name=""  >
                        <span class="text-danger" v-if="errores.price">{{errores.price[0]}}</span>
                    </div>

                    <div class="form-group">
                        <label for="image">Imagen</label>
                        <input type="file" @change="obtenerImagen" class="form-control-file">
                        <span class="text-danger" v-if="errores.image">{{errores.image[0]}}</span>
                    </div>

                    <figure>
                        <img width="200" height="200" :src="image" alt="Foto del producto">
                    </figure>

                    
                     <div class="my-4" >
                        <label for="status_product">Estado Producto</label>
                        <select name="status_product" v-model="product.status_product">
                            <option value="0">Inactivar</option>
                            <option value="1">Activar</option>
                        </select>   
                    </div>
                </form>
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
                    <th scope="col">Descripción</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Imagen</th>
                    <th scope="col" colspan="3" class="text-center">Acción</th>  
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products.data" :key="product.id">
                <td>{{product.name}}</td>
                <td>{{product.description}}</td>
                <td>{{product.price}}</td>
                <td>{{product.image}}</td>
                <td>
                    <button @click="update=true; openModal(product);" class="btn btn-warning">Editar</button>  
                </td>
                <td> 
                    <button @click="eliminar(product.id)" class="btn btn-danger">Eliminar</button>
                </td>
                </tr>  
            </tbody>
        </table>

        <div class="row">
            <div class="col-3 md-3 text-aling-right text-primary">
                {{products.from}} - {{products.to}} /total:{{products.total}}
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
                        <li class="page-item" :class="{disabled:pagination.page==products.last_page}"><a href="#" class="page-link" @click="pagination.page++; list()">&gt;</a></li>
                        <li class="page-item" :class="{disabled:pagination.page==products.last_page}"><a href="#" class="page-link" @click="pagination.page=products.last_page; list()">&raquo;</a></li>
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
              imagenMiniatura:'',
              product:{
                 name:'',
                 description:'',
                 price:'',
                 image:'',
                 status_product:'',
                },
                id:0,
                update:true,
                modal:0,
                titleModal:'',
                products:[],
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
            const res = await axios.get('api/product',{params:this.pagination});
            this.products = res.data;
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
              if(fin>this.products.last_page){
                 fin=this.products.last_page
              }
              for(let i = ini; i <= fin; i++ ) {
                  arrayN.push(i)
                }
                this.pages = arrayN   
          },
          async eliminar(id) {
            const res = await axios.delete('api/product/'+id);
            this.list();
          },
          async save() { 
              try {
                  if(this.update){
                   const res = await axios.put('api/product/' +this.id, this.product);
                }else{
                   const res = await axios.post('api/product/', this.product);
                }
                this.closeModal();
                this.list();     
              } catch (error) {
                  if(error.response.data){
                      this.errores = error.response.data.errors
                  }    
              }
              
            },
            openModal(data={}){
              this.modal=1;
              if(this.update) {
                 this.id = data.id;
                 this.titleModal="Modificar Producto";
                 this.product.name = data.name;
                 this.product.description = data.description;
                 this.product.price = data.price;
                 this.product.image = data.image;
                 this.product.status_product = data.status_product;  
                }else{
                 this.id = 0;
                 this.titleModal="Crear Producto";
                 this.product.name = '';
                 this.product.description = '';
                 this.product.price = '';
                 this.product.image = '';
                 this.product.status_product = '';
                }
            },
            closeModal(){
             this.modal=0;
             this.errores={};
            },
            obtenerImagen(e) {
                let file = e.target.files[0];
                this.product.image = file;
                this.cargarImagen(file);
            },
            cargarImagen(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.imagenMiniatura = e.target.result;
                }
                reader.readAsDataURL(file);
            },
            addProduct() {
                let formData = new FormData;
                    formData.append('name', this.product.name);
                    formData.append('description', this.product.description);
                    formData.append('price', this.product.price);
                    formData.append('image', this.product.image);
                    formData.append('status_product', this.product.status_product);

                    axios.post('api/product/',formData)
                        .then(response => {
                        console.log(response.data);
                })
            },
        },
        created() {
         this.list();
        },
        computed: {
                image() {
                    return this.imagenMiniatura;
                }
            }
        
     };    
</script>


<style >
.mostrar {
  display: list-item;
  opacity: 1;
  background: rgba(44,38,75,0.849);
}
</style>