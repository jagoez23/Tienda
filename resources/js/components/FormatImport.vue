<template>
    <div>
        <h1 class="text-center">Proceso de importación y exportación</h1>
        <hr/>
        <h2>En esta seccion usted podra importar y exportar datos en formato excel,
            en el siguiente enlace clik aqui, encontrara el formato correspondiente
            para realizar la importación.
        </h2>
        <div class="form-group-row">
          <div class="col-sm-10">
            <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" accept=".XLSX, .CSV" class="form-control">
          </div>
        </div>
        <br>
         <button v-on:click="EventSubir()" class="btn btn-primary">Subir</button>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                file:'',
            }
        },
        methods: {
                EventSubir(){
                let formData = new FormData();
                formData.append('file', this.file);
                axios.post('/api/product/import',
                        formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function(){
                        console.log('SUCCESS!!');
                    })
                    .catch(function(){
                        console.log('FAILURE!!');
                    });
            },
                handleFileUpload(){
                    this.file = this.$refs.file.files[0];
                },
                EventDescarga() {
                axios.get('/api/products/export')
                .then(function(){
                    console.log('SUCCESS!!'); 
                })
                .catch(function(){
                    console.log('FAILURE!!');
                });
            },
        }
    }
</script>

<style>

</style>