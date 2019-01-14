/**
 * @name : 移动端屏幕自动适配js 2.0
 * @intro : 默认宽度750，如果你的psd宽度不是这个,请在引用该js前定义iwidth宽度,然后按psd实际大小进行切图,viewport.js会根据实际屏幕大小适配
 * @update :
 * 1)废除了android 判断
 * 2)判断网页是否已包含viewport
 * @说明  
 * 兼容低版本安卓浏览器 target-densitydpi=device-dpi  使用设备原本的 dpi 作为目标 dp， 不会发生默认缩放
 */
(function(window){
        var iwidth = window.iwidth || 750,
        phoneWidth = parseInt(window.screen.width), //设备屏幕宽度
        phoneScale = phoneWidth/iwidth;//视口缩放比例
 
        if(window.document.querySelector('meta[name="viewport"]')){
                console.log('警告：网页中已存在viewport设置，建议移除');return;
        }

        //将视口缩放比例标记在html根属性中
        window.document.documentElement.setAttribute("data-scale", phoneScale);
        document.write('<meta name="viewport" content="width='+iwidth+', minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
})(window)
