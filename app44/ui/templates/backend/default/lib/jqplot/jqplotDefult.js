function makeChart(params)
{
   
        
    var j=0;
    var columnsData=[];
    var rowsData=[];
    if(params['data'].length === 0){
        $('#'+params['id']).html('داده ای ثبت نشده است').fadeIn('slow');
        $('#'+params['id']).removeClass('jqplot-target');
        $('#'+params['id']).attr('style' , 'text-align:center;');
    }
    else
    {
        //var params1=params;
        var k=0;    
        for(var i=0;i<params['data'][k].length;i++)
        {    
            columnsData[j]=params['data'][k][i]['columns'];
            if(params['data'][k][i]['rows'] !== null){
                rowsData[j]=params['data'][k][i]['rows'];
            }
            else{
                rowsData[j]= 0 ;
            }
            j++;
        }
    }
       
        
        
        params['rowsData'] = rowsData ;
        params['columnsData'] = columnsData ;
       
        
       console.log(params);
        chart(params);
}


function chart(params){
           
    $('#'+params['id']).html('').fadeOut('30000');
    $.jqplot.config.enablePlugins = true;
       
    
       
    var option = {
        // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
        animate: !$.jqplot.use_excanvas,
        seriesColors:['#85802b', '#00749F', '#73C774', '#C7754C', '#17BDB8','#CC9900','green','#CC66FF','#660033','#FFFF99','orange','gray','#CC00CC','#66CCFF','pink','red'],
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            pointLabels: {
                show: true
            },
            max:10,
            rendererOptions: {
                // Set varyBarColor to tru to use the custom colors on the bars.
                varyBarColor: true
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: params['columnsData'],
                
                tickOptions:{ 
                    angle: -30
                  }
            },
            yaxis: {
                min: 0,//parseInt(getMinOfArray(params['rowsData'])),
                max: (parseInt(getMaxOfArray(params['rowsData'])))
            }
        },
        highlighter: {
            show: false
        }
                
    };
            
    var newOption = params['newOption'] ;    
    newOption = $.extend(option , newOption);
        
    plot1 = $.jqplot( params['id'] , [params['rowsData']], newOption);
    $('#'+params['id']).fadeIn('slow');
}       
function makeChart_old(params){
        
    var j=0;
    var columnsData=[];
    var rowsData=[];
    if(params['data'].length === 0){
        $('#'+params['id']).html('داده ای ثبت نشده است').fadeIn('slow');
        $('#'+params['id']).removeClass('jqplot-target');
        $('#'+params['id']).attr('style' , 'text-align:center;');
    }
    else{
        for(var i=0;i<params['data'].length;i++)
        {    
            columnsData[j]=params['data'][i]['columns'];
            if(params['data'][i]['rows'] !== null){
                rowsData[j]=params['data'][i]['rows'];
            }
            else{
                rowsData[j]= 0 ;
            }
            j++;
        }
        params['rowsData'] = rowsData ;
        params['columnsData'] = columnsData ;   
        chart(params);
    }
}


function chart_old(params){
           
    $('#'+params['id']).html('').fadeOut('30000');
    $.jqplot.config.enablePlugins = true;
       
    if(params['range'] == 'day'){
        var labelAxes = 'ساعت';
    }
    else{
        var labelAxes = '';
    }
       
    var option = {
        // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
        animate: !$.jqplot.use_excanvas,
        seriesColors:['rgb(217,217,217)', 'rgb(83,153,214)', 'rgb(215,234,43)', 'rgb(252,92,92)', 'rgb(244,207,80)'],
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            pointLabels: {
                show: true
            },
            max:10,
            rendererOptions: {
                // Set varyBarColor to tru to use the custom colors on the bars.
                varyBarColor: true
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: params['columnsData'],
                label: labelAxes
            },
            yaxis: {
                min: 0,//parseInt(getMinOfArray(params['rowsData'])),
                max: (parseInt(getMaxOfArray(params['rowsData'])))
            }
        },
        highlighter: {
            show: false
        }
                
    };
            
    var newOption = params['newOption'] ;    
    newOption = $.extend(option , newOption);
        
    plot1 = $.jqplot( params['id'] , [params['rowsData']], newOption);
    $('#'+params['id']).fadeIn('slow');
}
    
function getMaxOfArray(numArray) {  
    var maxi =  Math.max.apply(null, numArray);
    if(maxi !== 0){
        var len = maxi.toString().length ;
        var start = maxi.toString().substr(0, 1);
            
        start = parseInt(start) + 2;
            
        for(var i=0 ; i < len - 1 ; i++){
                
            start = start + '0';
        }   
        return start;
    }
    else{
        return maxi;
    }  
}
    
function getMinOfArray(numArray) {
    var mini =  Math.min.apply(null, numArray);
    if(mini !== 0){
        var len = mini.toString().length ;
        var start = mini.toString().substr(0, 1);
        if(parseInt(start) - 1 > 0){
            start = parseInt(start) - 1;
        }
        for(var i=0 ; i < len - 1 ; i++){
                
            start = start + '0';
        }   
        return start;
    }
    else{
        return mini;
    }  
}
    
function chartPie(params){
    //$('#'+params['id']).html('');
    var data    = [];  
    var j       = 0;
    var rows;
    var columns;
        
    if(params['data'].length === 0){
        $('#'+params['id']).removeClass('jqplot-target');
        $('#'+params['id']).html('داده ای ثبت نشده است').fadeIn('slow');
        $('#'+params['id']).attr('style' , 'text-align:center;');
    }
    else{
        for(var i=0;i<params['data'].length;i++)
        {    
            if(params['data'][i]['rows'] !== null){
                rows = parseInt(params['data'][i]['rows']);
            }
            else{
                rows = 0 ;
            }
            if(params['data'][i]['columns'] !== null){
                columns = params['data'][i]['columns'];
            }
            else{
                columns = params['data'][i]['columnL'];
            }
                    
                    
            data[j] = [columns,rows];
            j++;
        }
    }
 
   // console.log(data);
          
    var plot1 = $.jqplot (params['id'],  [data],
    {
        seriesDefaults: {
            renderer: $.jqplot.PieRenderer,
            rendererOptions: {
                showDataLabels: true,
            //dataLabels: 'value'
            }
        },
        legend: {
            show:true, 
            location: 'e'
        }
    }
    );
}

function chartLine(params){
    var j=0;
    var columnsData=[];
    var rowsData=[];
    var columnsData1=[];
    var rowsData1=[];
    
    if(params['data'].length === 0){
        $('#'+params['id']).html('داده ای ثبت نشده است').fadeIn('slow');
        $('#'+params['id']).removeClass('jqplot-target');
        $('#'+params['id']).attr('style' , 'text-align:center;');
    }
    else
    {
        //var params1=params;
        var k=0;    
        for(var i=0;i<params['data'][k].length;i++)
        {    
            columnsData[j]=params['data'][k][i]['columns'];
            if(params['data'][k][i]['rows'] !== null){
                rowsData[j]=params['data'][k][i]['rows'];
            }
            else{
                rowsData[j]= 0 ;
            }
            j++;
        }
        k=1; 
        j=0;
        for (i=0;i<params['data'][k].length;i++)
        {    
            columnsData1[j]=params['data'][k][i]['columns'];
            if(params['data'][k][i]['rows'] !== null){
                rowsData1[j]=params['data'][k][i]['rows'];
            }
            else{
                rowsData1[j]= 0 ;
            }
            j++;
        }
        
        params['rowsData'] = rowsData ;
        params['columnsData'] = columnsData ;
       
        
        var params1=[];
        params1['rowsData'] = rowsData1 ;
        params1['columnsData'] = columnsData1 ;
       
        //params1['rowsData'] = rowsData[1] ;
        //params1['columnsData'] = columnsData[1] ; 
        
         //console.log(params1);
        chart2(params,params1);
    //chart2(params);
    }   
}

function chart2(params,params1){
           
    $('#'+params['id']).html('').fadeOut('30000');
    $.jqplot.config.enablePlugins = true;
       
   
       
    var option = {
        // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
        animate: !$.jqplot.use_excanvas,
        seriesColors: [ "green","rgba(78, 135, 194, 0.7)"],
        seriesDefaults: {
            rendererOptions: {
                smooth: true,
                animation: {
                    show: true
                }
            },
            showMarker: true,
            pointLabels: {
                show: false
            }
        },
        series: [
            {
                fill: false
               
            },
            {
                fill: true
               
            }
        ],
      
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: params['columnsData']
                
                 
            },
            yaxis: {
                min: 0,//parseInt(getMinOfArray(params['rowsData'])),
                max: (parseInt(getMaxOfArray(params['rowsData'])))
                
               
            }
        },
        highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: 'y',
            sizeAdjust: 7.5 , 
            tooltipLocation : 'ne'
        }
        
                
    };
            
    var newOption = params['newOption'] ;    
    newOption = $.extend(option , newOption);
        
    var plot2 = $.jqplot( params['id'] , [params['rowsData'],params1['rowsData']], newOption);
    $('#'+params['id']).fadeIn('slow');
   
}