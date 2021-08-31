<template>
    <button type="button" class="btn btn-sm btn-warning" @click.prevent="update()">Editar</button>
</template>

<script>
    export default {
        methods: {
            update(){
                Fire.$emit('update', this.$attrs.row);
            }
        }
    }
</script>
