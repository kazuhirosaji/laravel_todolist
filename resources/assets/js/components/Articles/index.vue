<template>
    <div>
        <create-article></create-article>
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
                this.get_articles();

                this.pusher = new Pusher("d34f42409f7dad1dc6ef", {
                    encrypted: true,
                    cluster: 'ap1'
                });

                //LaravelのEventクラスで設定したチャンネル名
                this.channel = this.pusher.subscribe('my-channel');

                //Laravelのクラス
                this.channel.bind('reference.event', this.add_message);
            },
            get_articles() {
                console.log('request api/articles');
                axios.get('/api/articles').then(res => {
                    console.log('api/articles responsed');
                    this.articles = res.data;
                });
            },
            notify_event() {
                this.$http.get('/api/pusher');
            },
            add_message(data) {
                $('#messages').prepend(data.message['title'] + ' / ' + data.message['content']);
                this.get_articles();
            }
        }
    }

</script>

