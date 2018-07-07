<template>
    <div>
        <div>{{ this.$route.params.id }}</div>
        <h1>{{ article.title }}</h1>
        <p>{{ article.content }} </p>
    </div>
</template>
<script>
    export default {
        created() {
            this.fetchArticle()
        },
        data() {
            return {
                article: []
            }
        },
        methods: {
            fetchArticle() {
                this.$http.get('/api/article/' + this.$route.params.id)
                .then(res =>  {
                    this.article = res.data
                })
            }
        }
    }
</script>