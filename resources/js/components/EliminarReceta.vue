<template>
    <input
        type="submit"
        class="btn btn-danger d-block w-100 mb-2"
        value="Eliminarx"
        @click="eliminarReceta"
        >
</template>
<script>
export default{
    props:['recetaId'],
    methods:{
        eliminarReceta(){
            this.$swal({
                title: 'Deseas eliminar esta receta?',
                text: "Una vez eliminada no se puede recuperar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, borrala',
                cancelButtonText:'No'
            }).then((result) => {
                if (result.value) {
                    const pararms={
                        id:this.recetaId
                    }
                    //enviar la peticion al servidor
                    axios.post(`/recetas/${this.recetaId}`, {pararms,_method:'delete'})
                    .then(respuesta=>{
                        this.$swal({
                            title:'Receta Eliminada',
                            text:'Se elimino la receta',
                            icon:'success'
                        });
                        //eliminar receta del DOM 
                        this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);
                    })
                    .catch(error=>{
                        console.log(error)
                    })
                    
                }
            })
        }
    }
}
</script>
