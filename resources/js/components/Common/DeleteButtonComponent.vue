<template>
    <button type="button" class="btn btn-sm btn-danger" @click.prevent="deletar()" :disabled="typeof this.$attrs.row.convidados != 'undefined' && this.$attrs.row.convidados.length > 0">Excluir</button>
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
