<!DOCTYPE html>
<head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/js/mask.js" type="text/javascript"></script>
<script>
    <?php // if(is_numeric($arg)||empty($arg)): ?>
    $(document).ready(function(){
    var cont_1=$('#d-1').html();
    var cont_2=$('#d-2').html();
    var cont_3=$('#d-3').html();
    var cont_4=$('#d-4').html();
    var cont_5=$('#d-5').html();
    var cont_6=$('#d-6').html();
    var cont_7=$('#d-7').html();
    var cont_8=$('#d-8').html();
    <?php if(!is_numeric($arg)||empty($arg)): $vkladka=3; else: $vkladka=$arg; endif; ?>
    $('#main-div').html(cont_<?php echo $vkladka; ?>);
    $('#a<?php echo $vkladka; ?>').css('background', '#F0F1F2');
    $('#a<?php echo $vkladka; ?>').css('color', '#FB3943');
    $('#content').hide();
    
    $('#a1').click(function(){
        $('#main-div').html(cont_1);
        $('.a_style').css('background', '#17222E');
        $('.a_style').css('color', '#FCFCFC');
        $('#a1').css('color', '#FB3943');
        $('#a1').css('background', '#F0F1F2');
    });
    $('#a2').click(function(){
        $('#main-div').html(cont_2);
        $('.a_style').css('background', '#17222E');
        $('.a_style').css('color', '#FCFCFC');
        $('#a2').css('color', '#FB3943');
        $('#a2').css('background', '#F0F1F2');
    });
    $('#a3').click(function(){
        $('#main-div').html(cont_3);
        $('.a_style').css('background', '#17222E');
        $('.a_style').css('color', '#FCFCFC');
        $('#a3').css('color', '#FB3943');
        $('#a3').css('background', '#F0F1F2');
    });
    $('#a4').click(function(){
        $('#main-div').html(cont_4);
        $('.a_style').css('background', '#17222E');
        $('.a_style').css('color', '#FCFCFC');
        $('#a4').css('color', '#FB3943');
        $('#a4').css('background', '#F0F1F2');
    });
    $('#a5').click(function(){
        $('#main-div').html(cont_5);
        $('.a_style').css('background', '#17222E');
        $('.a_style').css('color', '#FCFCFC');
        $('#a5').css('color', '#FB3943');
        $('#a5').css('background', '#F0F1F2');
    });
    $('#a6').click(function(){
        $('#main-div').html(cont_6);
        $('.a_style').css('background', '#17222E');
        $('.a_style').css('color', '#FCFCFC');
        $('#a6').css('color', '#FB3943');
        $('#a6').css('background', '#F0F1F2');
    });
    $('#a7').click(function(){
        $('#main-div').html(cont_7);
        $('.a_style').css('background', '#17222E');
        $('.a_style').css('color', '#FCFCFC');
        $('#a7').css('color', '#FB3943');
        $('#a7').css('background', '#F0F1F2');
    });
    $('#a8').click(function(){
        $('#main-div').html(cont_8);
        $('.a_style').css('background', '#17222E');
        $('.a_style').css('color', '#FCFCFC');
        $('#a8').css('color', '#FB3943');
        $('#a8').css('background', '#F0F1F2');
    });
    
});

jQuery(function($){   
    $(".phone").mask("+7-999-999-9999");   
});
function gid(i) {return document.getElementById(i);}
function CEL(s) {return document.createElement(s);}
function ACH(p,c) {p.appendChild(c);}

function getScrollWidth() {
  var dv = CEL('div');
  dv.style.overflowY = 'scroll';
  dv.style.width = '50px';
  dv.style.height = '50px';
  dv.style.position = 'absolute';
  dv.style.visibility = 'hidden';//при display:none размеры нельзя узнать. visibility:hidden - сохраняет геометрию, а выше было position=absolute - не сломает разметку
  ACH(document.body,dv);
  var scrollWidth = dv.offsetWidth - dv.clientWidth;
  document.body.removeChild(dv);
  return (scrollWidth);
}

function setSum(tbl, rr, cc) {
  var rowCount = tbl.rows.length, sum = '';
  for (var i=rr; i<rowCount; i++) {
    var row = tbl.rows[i];
    for (var j=cc; j < row.cells.length; j++) {
      sum = Math.floor(Math.random()*10000) + '';
      row.cells[i,j].innerHTML = sum.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ");
      row.cells[i,j].style.textAlign = 'right';
    }
  }
}

function FixAction(el) {
  FixHeaderCol(gid('t1'),1,1,1600,800);
//  FixHeaderCol(gid('t2'),2,1,400,214);
//  FixHeaderCol(gid('t3'),10,6,1000,415);
//  FixHeaderCol(gid('t4'),1,0,340,120);
//  FixHeaderCol(gid('t5'),0,2,340,145);

  el.parentNode.removeChild(el);
}

function FixHeaderCol(tbl, fixRows, fixCols, ww, hh) {
  var scrollWidth = getScrollWidth(), cont = CEL('div'), tblHead = CEL('table'), tblCol = CEL('table'), tblFixCorner = CEL('table');
  cont.className = 'divFixHeaderCol';
  cont.style.width = ww + 'px'; cont.style.height = hh + 'px';
  tbl.parentNode.insertBefore(cont,tbl);
  ACH(cont,tbl);

  var rows = tbl.rows, rowsCnt = rows.length, i=0, j=0, colspanCnt=0, columnCnt=0, newRow, newCell, td;

  // Берем самую первую строку (это rows[0]) и получаем истинное число столбцов в ТАБЛИЦЕ (учитывается colspan)
  for (j=0; j<rows[0].cells.length; j++) {columnCnt += rows[0].cells[j].colSpan;}
  var delta = columnCnt - fixCols;

  // Пробежимся один раз по всем строкам и построим наши фиксированные таблицы
  for (i=0; i<rowsCnt; i++) {
    columnCnt = 0; colspanCnt = 0;
    newRow = rows[i].cloneNode(true), td = rows[i].cells;
    for (j=0; j<td.length; j++) {
      columnCnt += td[j].colSpan;//кол-во столбцов в данной строке с учетом colspan
      if (i<fixRows) {//ну и заодно фиксируем заголовок
        newRow.cells[j].style.width = getComputedStyle(td[j]).width;
        ACH(tblHead,newRow);
      }
    }

    newRow = CEL('tr');
    for (j=0; j<fixCols; j++) {
      if (!td[j]) continue;
      colspanCnt += td[j].colSpan;
      if (columnCnt - colspanCnt >= delta) {
        newCell = td[j].cloneNode(true);
        newCell.style.width = getComputedStyle(td[j]).width;
        newCell.style.height = td[j].clientHeight - parseInt(getComputedStyle(td[j]).paddingBottom) - parseInt(getComputedStyle(td[j]).paddingTop) + 'px';
        ACH(newRow,newCell);
      }
    }
    if (i<fixRows) {ACH(tblFixCorner,newRow);}
    ACH(tblCol,newRow.cloneNode(true));
  } // Закончили пробегаться один раз по всем строкам и строить наши фиксированные таблицы

  tblFixCorner.style.position = 'absolute'; tblFixCorner.style.zIndex = '3'; tblFixCorner.className = 'fixRegion';
  tblHead.style.position = 'absolute'; tblHead.style.zIndex = '2'; tblHead.style.width = tbl.offsetWidth + 'px'; tblHead.className = 'fixRegion';
  tblCol.style.position = 'absolute'; tblCol.style.zIndex = '2'; tblCol.className = 'fixRegion';

  cont.insertBefore(tblHead,tbl);
  cont.insertBefore(tblFixCorner,tbl);
  cont.insertBefore(tblCol,tbl);

  var bodyCont = CEL('div');
  bodyCont.style.cssText = 'position:absolute; overflow:hidden;';

  // Горизонтальная прокрутка
  var divHscroll = CEL('div'), d1 = CEL('div');
  divHscroll.style.cssText = 'width:100%; bottom:0; overflow-x:auto; overflow-y:hidden; position:absolute; z-index:3;';
  divHscroll.onscroll = function () {
    var x = -1-this.scrollLeft + 'px';
    bodyCont.style.left = x;
    tblHead.style.left = x;
  };

  d1.style.width = tbl.offsetWidth + scrollWidth + 'px';
  d1.style.height = '2px';

  ACH(divHscroll,d1);
  ACH(bodyCont,tbl);
  ACH(cont,bodyCont);
  ACH(cont,divHscroll);

  // Вертикальная прокрутка
  var divVscroll = CEL('div'), d2 = CEL('div');
  divVscroll.style.cssText = 'height:100%; right:0; overflow-x:hidden; overflow-y:auto; position:absolute; z-index:3';
  divVscroll.onscroll = function () {
    var y = -this.scrollTop + 'px';
    bodyCont.style.top = y;
    tblCol.style.top = y;
  };

  d2.style.height = tbl.offsetHeight + scrollWidth + 'px';
  d2.style.width = scrollWidth + 'px';

  ACH(divVscroll,d2);
  ACH(cont,divVscroll);
} //FixHeaderCol


setSum(gid('t1'),0,0);
setSum(gid('t2'),2,1);
setSum(gid('t3'),2,2);
setSum(gid('t4'),0,0);
setSum(gid('t5'),0,0);
</script>
<link type="text/css" rel="stylesheet" href="/views/cab_style.css" />
<script type="text/javascript">
jQuery(document).ready(function(){
    FixAction(this);
    $('.boolit').hide();
jQuery('.spoiler-head').click(function(){
    $(this).parents('.spoiler-wrap').toggleClass("active").find('.spoiler-body').slideToggle();
});});

$(document).ready(function(){
//        var sum=0;
            var sum = 0;		
            var arr = $('input.sum:checked');
            arr.each(function(index, el){
            var pr = el.value;
            sum += parseFloat(pr);
            });
	$('#sum_span').html(sum);
        $('.sum').click(function(){
            var sum = 0;		
            var arr = $('input.sum:checked');
            arr.each(function(index, el){
            var pr = el.value;
            sum += parseFloat(pr);
            });   
	$('#sum_span').html(sum);  
        });
    });
</script>
<style>
    .divFixHeaderCol{
        max-height: 70% !important;
        max-width: 100% !important;
    }
    body{height: 95%}
</style>
</head>
<body>
    