<div class="container">
    <div id="calendar"></div>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });

    $(document).ready(function () {
        var date = new Date();
        date.setDate("12");
        console.log(date.getDate())
        $('#calendar').eCalendar({
            weekDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            textArrows: {previous: '<', next: '>'},
            eventTitle: 'Events',
            url: '',
            events: [
                <?php 
                    foreach($cal as $n) {
                        $dates = explode("-",$n->ENG_DATE);
                        $title = "MASA: ".$n->MASA.", PAKSHA: ".$n->PAKSHA.", THITHI: ".$n->THITHI;
                        $desc = "THITHI_SHORT_CODE: ".$n->THITHI_SHORT_CODE.", THITHI_LONG_CODE: ".$n->THITHI_LONG_CODE.", STAR: ".$n->STAR.", REMARKS: ".$n->REMARKS    
                ?>
                    {title: "<?=@$title; ?>" , description: "<?=@$desc; ?>", datetime: new Date(<?=$dates[0];?>, <?=$dates[1]-1;?>, <?=$dates[2];?>)},
                <?php }
				?>
            ],
            firstDayOfWeek: 0
        });
    });
</script>