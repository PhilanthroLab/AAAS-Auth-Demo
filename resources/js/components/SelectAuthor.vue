<template>
    <div class="main">
        <div class="logo">
            <img src="/img/logo_small.png">
        </div>
        <div class="article">
            <div class="question">
                <p class="paragraph">
                    Indicate which author you are (or are representing),<br>or select “Someone not listed here” if you don’t see the correct name.
                </p>
            </div>
        </div>
        <div class="form-box">
            <div class="form">
                <form @submit.prevent="proceed">
                    <div class="form-group">
                        <label>Select Author:</label>
                        <select v-model="selectedAuthor" required>
                            <option value="" disabled>— Select —</option>
                            <option v-for="author in authors" :value="author">{{author}}</option>
                            <option value="not listed">Someone not listed here</option>
                        </select>
                    </div>
                    <div class="form-footer">
                        <div class="info">
                            <span>Proceed with author pricing</span>
                        </div>
                        <button class="blue-btn ld-over-inverse" :class="{running: isLoading}" :disabled="isLoading" type="submit">
                            Proceed
                            <div class="ld ld-ring ld-spin"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SelectAuthor",
        data: () => ({
            isLoading: false,
            selectedAuthor: '',
            authors: [],
        }),
        methods: {
            getAuthors () {
                let isbn = this.$route.query.isbn
                axios.post('/internal-api/get-authors', {isbn})
                    .then(res => {
                        this.authors = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => {})
            },
            proceed () {
                let data = {
                    is_author: true,
                    selected_author: this.selectedAuthor,
                }
                this.isLoading = true
                axios.post('/internal-api/proceed', data)
                    .then(res => {
                        if (res.data.status === 'success') {
                            let jwt = res.data.data
                            if (window.opener) {
                                window.opener.postMessage({'status': 'success', 'jwt': jwt}, '*')
                            }
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => {this.isLoading = false})
            }
        },
        created () {
            this.getAuthors()
        }
    }
</script>

<style scoped>

</style>