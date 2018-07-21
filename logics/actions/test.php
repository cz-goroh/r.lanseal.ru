<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<form id="forma">
<input type="checkbox" name="nm1" id="id1" class="sum" value="1" />
<input checked type="checkbox" name="nm2" id="id2" class="sum" value="2" />
<input type="checkbox" name="nm3" id="id3" class="sum" value="3" />
<input type="checkbox" name="nm4" id="id4" class="sum" value="4" />
<input checked type="checkbox" name="nm5" id="id5" class="sum" value="5" />
</form>
<span id="span">
    
</span>
<script type="text/javascript">
    
    $(document).ready(function(){
//        var sum=0;
            var sum = 0;		
            var arr = $('input.sum:checked');
            arr.each(function(index, el){
            var pr = el.value;
            sum += parseFloat(pr);
            });
	$('#span').html(sum);
        $('.sum').change(function(){
            var sum = 0;		
            var arr = $('input.sum:checked');
            arr.each(function(index, el){
            var pr = el.value;
            sum += parseFloat(pr);
            });   
	$('#span').html(sum);  
        });
    });

</script>