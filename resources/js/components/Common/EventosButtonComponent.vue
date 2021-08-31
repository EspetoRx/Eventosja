<template>
    <button type="button" class="btn btn-sm btn-info" @click.prevent="eventos()">Eventos</button>
</template>

<script>
    export default {
        methods: {
            eventos(){
                Fire.$emit('eventos', this.$attrs.row);
            }
        }
    }
</script>
