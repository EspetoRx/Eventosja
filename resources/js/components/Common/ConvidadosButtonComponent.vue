<template>
    <button type="button" class="btn btn-sm btn-info" @click.prevent="convidados()">Convidados</button>
</template>

<script>
    export default {
        methods: {
            convidados(){
                Fire.$emit('convidados', this.$attrs.row);
            }
        }
    }
</script>
