### js动态创建单元格

```javascript
function createtrtd(newname,newtime,newage,newflase){
      // alert(name);
       // 获取要插入单元格位置的ID
       var Con = document.getElementById("tbodynames");
       // 获取要插入单元格位置的ID的第一个元素
       var first = Con.firstElementChild
       // 创建tr元素
       var tr = document.createElement("tr");
       // Con.appendChild(tr);
       // 将单元格添加在第一行
       Con.insertBefore(tr,first);
       // 创建td元素
       var tdname = document.createElement("td");
       var tdtime = document.createElement("td");
       var tdage = document.createElement("td");
       var tdisfalse = document.createElement("td");
       console.log('单元格位置',Con);
       console.log(tr);
       // console.log(td);
       tr.appendChild(tdname);
       tr.appendChild(tdtime);
       tr.appendChild(tdage);
       tr.appendChild(tdisfalse);
       // tr.insertBefore(td,tr);
       // td.innerHTML = "aaaaa";
       tdname.innerHTML = newname;
       tdtime.innerHTML = newtime;
       tdage.innerHTML = newage;
       tdisfalse.innerHTML = newflase;
    }
```

### 调用本地apk

```javascript
function openclient(app_url,down_url) {
            var startTime = Date.now();
            var ifr = document.createElement('iframe');
//这里可以进行判断是安卓还是IOS利用不同的链接打开app
//            ifr.src = ua.indexOf('os') > 0 ? config.scheme_IOS : config.scheme_Adr;
            //和移动端定好的协议 类似于:  com.dalongtech.boxpc://openIntegralPage
            ifr.src = app_url;
            ifr.style.display = 'none';
            //生成一个iframe
            document.body.appendChild(ifr);
            //倒计时2000毫秒跳转到下载页面
            var t = setTimeout(function() {
                var endTime = Date.now();
                if (!startTime || endTime - startTime < 2000 + 200) {
                    window.location = down_url;
                } else {

                }
            }, 2000);
            //如果2000毫秒内打开了apk 即网页失去焦点  阻止跳转
            window.onblur = function() {
                clearTimeout(t);
            }
        }
```

