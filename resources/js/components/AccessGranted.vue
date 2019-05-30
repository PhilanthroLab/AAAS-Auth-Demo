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
                    <a href="select_author.html">YES</a>
                </div>
                <div class="disabled">
                    <a href="">NO</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AccessGranted"
    }
</script>

<style scoped>

</style>