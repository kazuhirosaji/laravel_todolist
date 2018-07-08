<template>
    <div>
        <p>
            <router-link to='/article/create'>記事作成</router-link>
        </p>  
        <div v-for="article in articles">
            <h1>
                <router-link :to="'/articles/' + article.id">{{ article.title }}</router-link>
            </h1>
            <p>
                {{ article.content }}
            </p>
        </div>

        <input type="button" value="push" v-on:click="notify_event">
        <ul id="messages"></ul>

    </div>

</template>

<script>
    export default {
        created() {
            this.fetchArticles();
        },
        data() {
            return {
                articles: []
            }
        },
        methods: {
            fetchArticles() {
                this.$http.get('/api/articles')
                .then(res =>  {
                    this.articles = res.data
                    console.log(this.articles);
                })
            },
            notify_event() {
                console.log('notify event');
                this.$http.get('/api/pusher');
            }
        }
    }

</script>

