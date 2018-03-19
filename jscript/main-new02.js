var bodyHTML;
var currentDisplayMode = "";
var newDisplayMode = "";

function domMobile(){
  console.log("domMobile");
  var ribbons = document.getElementsByTagName("H1")[0];
  var ribbonArr = ribbons.innerHTML.split("<br>");
  ribbons.innerHTML="";
  ribbons.appendChild(document.createElement("span"));
  for(x=0;x<ribbonArr.length;x++){
    var newspan1 = document.createElement("span");
    var newtext1 = document.createTextNode(ribbonArr[x]);
    var newspan2 = document.createElement("span");
    newspan1.appendChild(newtext1);
    ribbons.appendChild(newspan1);
    ribbons.appendChild(newspan2);
  }
  var social = document.createElement("span");
  social.appendChild(document.getElementById('social'));
  ribbons.appendChild(social);
  ribbons.appendChild(document.createElement("span"));
  var portrait = document.createElement("span");
  portrait.appendChild(document.getElementById('portrait'));
  ribbons.appendChild(portrait);

  var collections = document.getElementsByClassName('collection');
  for(x=0;x<collections.length;x++){
    var thisCollection = collections[x];
    thisCollection.insertBefore(document.createElement("span"), thisCollection.getElementsByTagName("H2")[0]);
    var listItems = thisCollection.getElementsByTagName("li");
    for(y=0;y<listItems.length;y++){
      var newSpan = document.createElement("span");
      newSpan.appendChild(listItems[y].getElementsByTagName("a")[0]);
      thisCollection.insertBefore(newSpan, listItems[y]);
    }

    var newspan0 = document.createElement("span");
    thisCollection.appendChild(newspan0);
    var newspan0 = document.createElement("span");
    thisCollection.appendChild(newspan0);
  }
}

function domTablet(){
  console.log("domTablet");
  var header = document.getElementsByTagName("h1")[0];
  var headerArr = header.innerHTML.split("<br>");
  var social = document.getElementById('social');

  for(x=0;x<headerArr.length;x++){
    var header = document.createElement("h1");
    var newHeaderText = document.createTextNode(headerArr[x]);
    header.appendChild(newHeaderText);
    var newList = document.createElement("li");
    newList.classList.add("headline");
    newList.appendChild(header);
    social.appendChild(newList);
  }
  document.getElementsByTagName("h1")[0].remove();
  for(x=0;x<17;x++){
    var newHole = document.createElement("li");
    newHole.classList.add("hole");
    social.appendChild(newHole);
  }
  for(x=0;x<25;x++){
    var newBlank = document.createElement("li");
    newBlank.classList.add("blankCell");
    social.appendChild(newBlank);
  }
  var allLists = document.getElementsByTagName("ul");
  var listCount = allLists.length;
  var newList = document.createElement("ul");
  newList.id = "bricks";
  for(var x=1;x<allLists.length;x++){
    var listID = allLists[x].id;
    var listItems = allLists[x].children;
    for(var y=0;y<listItems.length;y++){
      if(listItems[y].tagName.toLowerCase()=="li"){
        var newDiv = document.createElement("div");
        newDiv.classList.add("content");
        newDiv.innerHTML = listItems[y].innerHTML;
        var newListItem = document.createElement("li");
        newListItem.appendChild(newDiv);
        newListItem.classList.add(listID);
        newListItem.classList.add("brick");
        newList.appendChild(newListItem);
      }
    }
  }
  document.body.appendChild(newList);
  for(var x=listCount-1;x>0;x--){
    allLists[x].remove();
  }

  allItems = document.getElementsByClassName("brick");

  for(x=0;x<allItems.length;x++){
    imagesLoaded( allItems[x], resizeInstance);
  }

  resizeAllGridItems();
}

function domDesktop(){
  console.log("domDesktop");
  var h1 = document.getElementsByTagName("h1")[0];
  var portraitDiv = document.createElement("div");
  var portrait = document.getElementsByTagName("img")[0];
  portraitDiv.appendChild(portrait);
  var lists = document.getElementsByTagName("ul");
  var holder = document.createElement("div");
  var grid1 = document.createElement("div");
  var grid2 = document.createElement("div");
  var grid3 = document.createElement("div");
  var headerGrid = document.createElement("div");
  holder.id = "holder";
  grid1.id = "grid1";
  grid2.id = "grid2";
  grid3.id = "grid3";
  grid1.classList.add("grid");
  grid2.classList.add("grid");
  grid3.classList.add("grid");
  holder.appendChild(grid1);
  holder.appendChild(grid2);
  holder.appendChild(grid3);
  document.body.insertBefore(holder, h1);
  headerGrid.appendChild(h1);
  headerGrid.appendChild(lists[0]);
  grid2.appendChild(headerGrid);
  grid2.appendChild(portraitDiv);
  var listCount = lists.length;
  for(var x=0; x<listCount; x++){
    if(lists[x].id!="social"){
      var listItems = lists[x].getElementsByTagName("li");
      for(var y=0; y<listItems.length; y++){
        var textDiv = document.createElement("div");
        for(var z=0; z<listItems[y].childNodes.length;z++){
          if(listItems[y].childNodes[z].nodeName=="P"){
            var dupNode = listItems[y].childNodes[z].cloneNode(true);
            textDiv.appendChild(dupNode);
          }else if(listItems[y].childNodes[z].nodeName=="A"){
            if(listItems[y].childNodes[z].childNodes[0].nodeName=="H3"){
              var dupNode = listItems[y].childNodes[z].cloneNode(true);
              grid1.appendChild(dupNode);
            }else if(listItems[y].childNodes[z].childNodes[0].nodeName=="IMG"){
              var dupNode = listItems[y].childNodes[z].cloneNode(true);
              grid3.appendChild(dupNode);
            }
          }
        }
        grid2.appendChild(textDiv);
      }
    }
  }
  for(var x=listCount-1;x>0;x--){
    lists[x].remove();
  }
  var c1 = 1;
  var r1 = 4;
  var c2 = 5;
  var r2 = 10;
  var c3 = 96;
  var r3 = 6;

  for(var x=0; x<grid3.childNodes.length; x++){
    grid1.childNodes[x].style.gridColumnStart = c1;
    grid1.childNodes[x].style.gridRowStart = r1;
    grid2.childNodes[x+2].style.gridColumnStart = c2;
    grid2.childNodes[x+2].style.gridRowStart = r2;
    grid3.childNodes[x].style.gridColumnStart = c3;
    grid3.childNodes[x].style.gridRowStart = r3;
    if(x%3==2){
      c1-=10;
      r1-=6;
      c2-=10;
      r2+=4;
      c3-=4;
      r3-=6;
    }else{
      c1+=5;
      r1+=8;
      c2+=5;
      r2+=3;
      c3-=3;
      r3+=8;
    }
  }  
}

function resizeGridItem(item){
  grid = document.getElementById("bricks");
  rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
  rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
  rowSpan = Math.ceil((item.querySelector('.content').getBoundingClientRect().height-20+rowGap)/(rowHeight+rowGap));
  item.style.gridRowEnd = "span "+rowSpan;
}

function resizeAllGridItems(){
  allItems = document.getElementsByClassName("brick");
  for(x=0;x<allItems.length;x++){
    resizeGridItem(allItems[x]);
  }
}

function resizeInstance(instance){
  item = instance.elements[0];
  resizeGridItem(item);
}


function loaded(){
  console.log("loaded");
  bodyHTML = document.getElementsByTagName("BODY")[0].innerHTML;
  getSize();
}

function getSize(){
  console.log("get size");
  if(window.innerWidth<=600){
    newDisplayMode = "mobile";
    if(newDisplayMode!=currentDisplayMode){
      currentDisplayMode = "mobile";
      document.getElementsByTagName("BODY")[0].innerHTML = bodyHTML;
      domMobile();
    }
  }else if(window.innerWidth<=900){
    newDisplayMode = "tablet";
    if(newDisplayMode!=currentDisplayMode){
      currentDisplayMode = "tablet";
      document.getElementsByTagName("BODY")[0].innerHTML = bodyHTML;
      domTablet();
    }
  }else{
    newDisplayMode = "desktop";
    if(newDisplayMode!=currentDisplayMode){
      currentDisplayMode = "desktop";
      document.getElementsByTagName("BODY")[0].innerHTML = bodyHTML;
      domDesktop();
    }
  }
}

document.onload = loaded();
window.onresize = function() {
  console.log("resized");
  getSize();
};


