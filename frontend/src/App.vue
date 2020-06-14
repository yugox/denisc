<template>
  <div id="app">
    <Header/>
    <main style="margin-bottom: 120px" role="main" class="container">
        <router-view></router-view>
    </main>
    <Footer/>
  </div>
</template>

<script>
import Header from './layout/Header.vue'
import Footer from './layout/Footer.vue'

export default {
  name: 'App',
  components: {
    Header,
    Footer
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
