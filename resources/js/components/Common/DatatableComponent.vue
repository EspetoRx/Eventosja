<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>

<script>
    export default {
        data: () => ({
        }),
        props: {
            columns: {
                required: true,
            },
            rows: {
                required: true,
            },
            page: {
                required: true,
            },
            filter: {
                required: true,
            },
            perPage: {
                required: true
            },
        },
        created: function () {
            this.$emit('getData');
        }
    }

</script>