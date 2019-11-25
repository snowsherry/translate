<template>
    <div>
      <h1 style="text-align: center">Test Page</h1>
      <div class="button" style="border: 1px solid #c0c4cc; width: 200px; line-height: 40px; margin: 20px auto; font-size: 24px;" @click="callSp">执行</div>
    </div>
</template>

<script>
    export default {
        name: "test",
      methods:{
        callSp(){
          try {
            sp();
            gio('sendPage'); // 放在send之后
          }catch (e) {

          }
        }
      },
      mounted() {

      }
    }
</script>

<style scoped>

</style>
