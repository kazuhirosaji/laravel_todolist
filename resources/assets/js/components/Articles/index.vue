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
                articles: [],
                pusher: null,
                channel: null,
            }
        },


        methods: {
            fetchArticles() {
                this.$http.get('/api/articles')
                .then(res =>  {
                    this.articles = res.data
                });

                this.pusher = new Pusher("d34f42409f7dad1dc6ef", {
                    encrypted: true,
                    cluster: 'ap1'
                });

                //LaravelのEventクラスで設定したチャンネル名
                this.channel = this.pusher.subscribe('my-channel');

                //Laravelのクラス
                this.channel.bind('reference.event', this.add_message);
            },
            notify_event() {
                this.$http.get('/api/pusher');
            },
            add_message(data) {
                $('#messages').prepend(data.message['title'] + ' / ' + data.message['content']);
            }
        }
    }

</script>

