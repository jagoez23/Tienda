<template>
    <div>
        <h1 class="text-center">Detalle de la venta</h1>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nombre Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Total</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha de Compra</th>
                </tr>
            </thead>
            <tbody>
               <tr v-for="order_detail  in orders_details" :key="order_detail.id">
                    <td>{{order_detail.name}}</td>
                    <td>{{order_detail.quantity}}</td>
                    <td>{{order_detail.price | formatNumber}}</td>
                    <td>{{order_detail.price * order_detail.quantity | formatNumber}}</td> 
                    <td>{{order_detail.status}}</td>
                    <td>{{isToday(order_detail.created_at)}}</td>  
               </tr>    
            </tbody>        
        </table>

        <div class="row">
            <div class="col-3 md-3 text-aling-right text-primary">
                {{orders_details.from}} - {{orders_details.to}} /total:{{orders_details.total}}
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
                        <li class="page-item" :class="{disabled:pagination.page==orders_details.last_page}"><a href="#" class="page-link" @click="pagination.page++; list()">&gt;</a></li>
                        <li class="page-item" :class="{disabled:pagination.page==orders_details.last_page}"><a href="#" class="page-link" @click="pagination.page=orders_details.last_page; list()">&raquo;</a></li>
                    </ul>
                </nav>
            </div>    
        </div>  
    </div>
</template>

<script>
import moment from 'moment'
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("$0,0");
});

export default {
    props:{
        order_id:{
            required:true,
            type: Number 
        }
    },
    data() {
        return {
            order_detail:{
                nombre:"",
                cantidad:"",
                precio:"",
                estado:"",
                total:"",
                fecha:"",
            },
            orders_details:[],
            pagination:{
                    page:1,
                    per_page:5,
                },
                pages:[], 
        };
    },
    methods: {
        async list() {
                const res = await axios.get('/api/order_detail/'+ this.order_id,{params:this.pagination});
                this.orders_details = res.data;
                console.log(JSON.stringify(this.orders_details));
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
              if(fin>this.orders_details.last_page){
                 fin=this.orders_details.last_page
              }
              for(let i = ini; i <= fin; i++ ) {
                  arrayN.push(i)
                }
                this.pages = arrayN   
            },
            isToday(date) {
                return moment(date).format('L');
            }
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
