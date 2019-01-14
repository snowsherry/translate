<template>
  <div>
    <div class="page page1" v-show="scene==1">
      <div class="logo"></div>
      <div class="searchBox">
        <div class="mcon">
          <input type="text" id="key"  width="600" placeholder="请输入要翻译的文本" @focus="scene=2">
        </div>
        <div class="serachicon"></div>
      </div>
      <div class="hot">
        <div class="guide hoticon">热门查询</div>
        <div class="hotcon">
          <span v-for="(item,key) in hotList" :key="item" @click="setkey(item)">{{item}}</span>
        </div>
      </div>
    </div>
    <div class="page page2" v-show="scene==2">
      <div class="logo"></div>
      <div class="guide">输入语句</div>
      <div class="scon">
        <input type="text" id="key2"  v-model="query">
        <div class="close"></div>
      </div>
      <div class="guide">选择目标语言</div>
      <div class="table">
        <li v-for="(item,i) in languages" :key="item.key" ><a  :name="item.name" @click="chooseLangs(i)" :class="['react',{'on':item.choosed}]">{{item.name}}</a></li>
      </div>
      <div class="sub" @click="getRs">生成</div>
      <div class="guide">结果</div>
      <div class="result">
        <div id="copyBtn" class="copy-btn" v-clipboard:copy="translateDataStr" v-clipboard:success="onCopy" v-clipboard:error="onError" v-show="translateData.length>0">Copy</div>
        <div class="rs" id="rs">
          <span v-for="(item,key) in translateData" :key="key">{{item}}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {getHot,getLangs,getResult} from "../../js/lang";
  import { Message } from 'element-ui';
  import  Vue from "vue"
  import VueClipboards from 'vue-clipboard2'
  Vue.use(VueClipboards);
  export default {
        name: "index",
        data(){
          return{
              query:"",
              hotList:[],
              languages:[],
              translateData:[],
              scene:1,
              isSub:false,

          }
        },
        beforeMount(){
          getHot().then(res=>{
            //console.log(res);
            if(res.data.msg=='ok'){
              this.hotList=res.data.data;
            }
          })

          getLangs().then(res=>{
            if(res.data.msg=='ok'){
              let rs=[];
              console.log(res);//JSON格式的
              this.languages=res.data.data;
              for(let  key in this.languages ){
               // console.log('single',this.languages[key])
                let langObj={
                  key:key,
                  choosed:key=='en'?true:false,
                  name:this.languages[key],
                }
                rs.push(langObj);
              }
              this.languages=rs;
              console.log('this.languages',this.languages)
            }
          })
        },
        methods:{

          onCopy: function (e) {
              alert('复制成功！')
          },

          onError: function (e) {
            console.log('复制失败！')
          },

          setkey(q){
            this.scene=2;
            this.query=q;
          },
          chooseLangs(i){
              this.$set(this.languages[i], `choosed`, !this.languages[i].choosed)
             // this.language.choosed=!this.language[i].choosed;
          },
          getRs(){
              if(this.isSub) return;
              if(this.checkQuery()&&this.checkLangs()){
                let params={
                  query:this.query,
                  langs:this.choosedLangs,
                }
                console.log('params',params);
                getResult(params).then(rs=>{
                  console.log(rs);
                  this.translateData=rs.data.data;
                  this.isSub=false;
                });
              }
              this.isSub=false;

          },
          checkQuery(){
            if(this.query==""){
              this.$message({
                showClose: true,
                message: '请输入查询需要的内容',
                type: 'error',
               // duration:0
              });
              return false;
            }
            return true;
          },
          checkLangs(){
              if(this.chooseLangs==""){
                this.$message({
                  showClose: true,
                  message: '请选择目标语言',
                  type: 'error',
                  //duration:0
                });
                return false;
              }
            return true;
          },
        },
        computed:{
          translateDataStr(){
            return this.translateData.join("\r\n");
          },
          choosedLangs(){
            let sp=[];
            this.languages.forEach((item)=>{
              if(item.choosed){
                sp.push(item.key);
              }
            })
            return sp.join('&');
          }
        }
    }
</script>

<style>
  *,body,div,p,span,img,ul,li,a{ margin:0; padding:0;}
  ul,li{ list-style:none;}
  body{ background:#f0efed; font-size:36px;}
  .page{ width:750px; margin:0 auto;}
  .logo{ width:329px; height:70px; margin:40px auto 100px; background:url('../assets/image/logo.png');}
  .page1{ padding-top:140px;}
  .page1 .searchBox{ width:590px; height:80px; margin:0 auto; border:2px solid #bababa; border-radius:90px; padding:5px 45px; background:#fff; overflow:hidden;}
  .page1 .searchBox .mcon{width:500px; float:left;}
  .page1 .searchBox input{ border:none; line-height:80px; font-size:36px; width:100%; margin-left:-20px;}
  .page1 .serachicon{ width:48px; height:48px;background:url('../assets/image/search.png'); background-size:cover;float:right; margin:20px -20px 0 0;}
  .page1 .hot{ margin:80px auto 0; width:700px;}
  /*.page1 .hot .hoticon{ width:74px; height:95px;background:url('./hot.png'); color:#c00;}*/
  .guide{ color:#333;margin:0 0 30px  16px;}
  .page1 .hot .hoticon{  color:#c00;}
  .page1 .hot .hotcon{ line-height:45px; font-size:30px; color:#444; margin-top:20px;}
  .page1 .hot .hotcon span{ margin:20px; display:inline-block;}
  .page2{ color:#333; }
  .page2 h4{ text-align:center; margin:60px auto;}
  .table{    min-height: .8rem;
    position: relative;
    overflow: hidden;
    z-index: 0;
    background:#FDFDFC;
    width:700px; margin:20px auto;
  }
  .table:before {
    content: '';
    position: absolute;
    width: 25%;
    left: 25%;
    height: 100%;
    border-left: 1px solid #ddd8ce;
    border-right: 1px solid #ddd8ce;
  }
  .table:after {
    content: '';
    position: absolute;
    width: 10%;
    left: 75%;
    height: 100%;
    border-left: 1px solid #ddd8ce;
    border-right: none;
  }
  .table li{
    display: inline-block;
    width: 25%;
    height: 60px;
    line-height: 60px;
    font-size: 28px;
    text-align: center;
    border-bottom: 1px solid #ddd8ce;
    margin-bottom: -1px;
    float: left;
    position: relative;
    z-index: 10;
  }
  a.react, label.react {
    display: block;
    color: inherit;
    height: 100%;
    overflow-x: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  li .react.on{ color:#fff; font-weight:bold; background:#1aac19;}
  .scon{ width:660px; height:70px;border-radius:70px; padding:0 20px;background:#fff;margin:20px auto; overflow:hidden;}
  .scon #key2{ border:none; width:600px; line-height:70px; height:70px;background:#fff;border-radius:70px; font-size:30px; color:#000;}
  .result{ width:660px; margin:20px auto 60px; background:#fff; line-height:50px; font-size:28px; color:#000; min-height:160px; padding:10px 10px 10px 30px; font-weight:bold; position:relative;}
  #rs{ display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;}
  .sub{ width:600px; height:80px; line-height:80px; text-align:center; margin:40px auto; background:#1aac19; color:#fff; font-size:30px; font-weight:bold; border-radius:10px;}
  .copy-btn{
    position: absolute;
    right: 0;
    top: -36px;
    border: 1px solid #F18F35;
    color: #F18F35;
    border-radius: 15px;
    padding: 0 8px;
    text-align: center;
    line-height: 30px;
    height: 30px;
    cursor: pointer;
    font-weight: normal;
    font-size: 20px;
  }
  .copy-btn:hover{ background: #F18F35; color: #ffffff; border: none;}
@media (max-width: 750px) {
  .el-message{ transform: scale(1.5,1.5); left:185px; top: 60px; }
}
</style>
