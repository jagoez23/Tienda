<template>
    <div>
        <h1 class="text-center">Estado de la orden</h1>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Respuesta</th>
                    <th scope="col">Url</th>
                </tr>
            </thead>
            <tbody>
               <tr v-for="order  in orders.data" :key="order.id">
                    <td>{{order.status}}</td>
                    <td>{{order.created_at}}</td>
                    <td>{{order.requestId}}</td> 
                    <td>{{order.processUrl}}</td>  
               </tr>    
            </tbody>        
        </table>

        <div class="row">
            <div class="col-3 md-3 text-aling-right text-primary">
                {{orders.from}} - {{orders.to}} /total:{{orders.total}}
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
                        <li class="page-item" :class="{disabled:pagination.page==orders.last_page}"><a href="#" class="page-link" @click="pagination.page++; list()">&gt;</a></li>
                        <li class="page-item" :class="{disabled:pagination.page==orders.last_page}"><a href="#" class="page-link" @click="pagination.page=orders.last_page; list()">&raquo;</a></li>
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
            order:{
                estado:"",
                fecha:"",
            },
            orders:[],
            pagination:{
                    page:1,
                    per_page:5,
                },
                pages:[], 
        };
    },
    methods: {
        async list() {
                const res = await axios.get('/api/order',{params:this.pagination});
                this.orders = res.data;
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
              if(fin>this.orders.last_page){
                 fin=this.orders.last_page
              }
              for(let i = ini; i <= fin; i++ ) {
                  arrayN.push(i)
                }
                this.pages = arrayN   
            },
    },
    created() {
         this.list();
        },
    
}
</script>

<style >
.mostrar {
  display: list-item;
  opacity: 1;
  background: rgba(44,38,75,0.849);
}
</style>
