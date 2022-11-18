import axios from 'axios'
console.log('process.env.NODE_ENV',process.env.NODE_ENV)
let apiUrl;
if(process.env.NODE_ENV=="production"||1){
   apiUrl="http://node.huokele.com/lang";
}else{
    apiUrl="http://localhost:3000/lang";
}
export  function getHot(){
    return new Promise((resolve,reject)=>{
        axios({
          method:"get",
          //data:params,
          url:`${apiUrl}/hot`,
        }).then(res =>{
          resolve(res)
        }).catch(res =>{
          console.error(res);
          reject(res)
        })
    })
}

export  function getLangs(){
  return new Promise((resolve,reject)=>{
    axios({
      method:"get",
     // data:params,
      url:`${apiUrl}/list`,
    }).then(res =>{
      resolve(res)
    }).catch(res =>{
      console.error(res);
      reject(res)
    })
  })
}


export  function getResult(params){
  return new Promise((resolve,reject)=>{
    axios({
      method:"post",
      data:params,
      url:`${apiUrl}/result`,
    }).then(res =>{
      resolve(res)
    }).catch(res =>{
      console.error(res);
      reject(res)
    })
  })
}
