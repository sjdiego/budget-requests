<template>
    <div>
        <p>Categoría</p>
        <select-options-component
            v-model="category"
            @input="setCategory"
            :options="categories">
        </select-options-component>

        <p>Subcategoría</p>
        <select-options-component
            v-model="subcategory"
            @input="setSubcategory"
            :options="subcategories">
        </select-options-component>

        <p>Preferencia precio</p>

        <select-options-component
            v-model="desiredPrice"
            @input="setDesiredPrice"
            :options="desiredPrices"></select-options-component>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                category: '',
                categories: {},
                subcategory: '',
                subcategories: {},
                desiredPrice: '',
                desiredPrices: {
                    'b': 'Lo más barato',
                    'r': 'Relación calidad/precio',
                    'c': 'Mejor calidad'
                }
            }
        },
        mounted() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                axios
                    .get(process.env.MIX_APP_URL + '/api/category/list')
                    .then(response => {
                        let categories = {};
                        response.data.forEach((item) => {
                            categories[item.id] = item.name
                        });
                        this.categories = categories
                        this.$store.commit('setCategories', categories)
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            getSubcategories(categoryId) {
                axios
                    .get(process.env.MIX_APP_URL + '/api/category/find/' + categoryId)
                    .then(response => {
                        let subcategories = {};
                        response.data.children.forEach((item) => {
                            subcategories[item.id] = item.name
                        });
                        this.subcategories = subcategories
                        this.$store.commit('setSubcategories', subcategories)
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            setCategory: function(target) {
                this.category = target.value
                this.$store.commit('setCategory', target.value)
                this.getSubcategories(target.value)
            },
            setSubcategory(target) {
                this.$store.commit('setSubcategory', target.value)
                this.subcategory = target.value
            },
            setDesiredPrice: function(target) {
                this.desiredPrice = target.value
                this.$store.commit('setDesiredPrice', target.value)
            }
        }
    }
</script>

<style lang="scss" scoped>
    p {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
