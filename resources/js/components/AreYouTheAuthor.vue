<template>
    <div class="main">
        <div class="logo">
            <img src="img/logo_small.png">
        </div>
        <div class="article">
            <div class="question">
                <p class="paragraph">User Account Verified!</p>
            </div>
            <div class="question">
                <h1>Are you the author of the <span class="italic">AAAS</span> content?</h1>
            </div>
            <div class="answers">
                <div>
                    <router-link to="/select-author?isAuthor=true">YES</router-link>
                </div>
                <div class="disabled">
                    <router-link to="/select-author?isAuthor=false">NO</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AreYouTheAuthor"
    }
</script>

<style scoped>

</style>