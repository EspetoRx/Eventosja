<template>
    <button type="button" class="btn btn-sm btn-danger" @click.prevent="deletar()">Excluir</button>
</template>

<script>
    export default {
        methods: {
            deletar(){
                Fire.$emit('deletar', this.$attrs.row);
            }
        }
    }
</script>
