$(function(){
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true,
        language: 'fr',
        startDate: 'd',
        endDate: '31/12/2017',
        daysOfWeekDisabled: ['2', '0'],
        datesDisabled: ['01/05/2017', '01/11/2017', '25/12/2017'],
        todayBtn: 'linked',
    });

    function dateValid(){
        var date_reserv = $('.datepicker').val();
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }
        var today = dd+'/'+mm+'/'+yyyy;

        var today2 = new Date();
        var today3 = new Date();
        today3.setHours(14);
        today3.setMinutes(00);

        if(today2 >= today3 && today >= date_reserv){
            $(".selectOption option[value='Journée']").hide();
            $(".selectOption option[value='Journée']").removeAttr("selected", "selected");
            $(".selectOption option[value='Demi-Journée']").attr("selected", "selected");
        }
        else{
            $(".selectOption option[value='Journée']").show();
            $(".selectOption option[value='Demi-Journée']").removeAttr("selected", "selected");
            $(".selectOption option[value='Journée']").attr("selected", "selected");
        }
    }
    dateValid();
    $('.datepicker').datepicker()
        .on('changeDate', function(e) {
            dateValid();
        });
});