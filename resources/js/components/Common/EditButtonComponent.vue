<template>
    <router-link :to="`${this.$router.app.$route.fullPath}/edit/${this.$attrs.row.id}`" class="btn btn-sm btn-warning" append>Editar</router-link>
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
