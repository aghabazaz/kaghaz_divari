function jalaliTOgregorian(d)
{
    //alert('ok');
    var adjustDay = 0;
    if(d[1]<0)
    {
        adjustDay = leap_persian(d[0]-1)? 30: 29;
        d[1]++;
    }
    var gregorian = jd_to_gregorian(persian_to_jd(d[0], d[1] + 1, d[2])-adjustDay);
    gregorian[1]--;
    gregorian[2]--;
    if(gregorian[1]<10)
    {
        gregorian[1]='0'+gregorian[1];

    }
    if(gregorian[2]<10)
    {
        gregorian[2]='0'+gregorian[2];

    }
    //alert();
    return gregorian;
}
//------------------------------------------------------------------------------
function gregorianTOjalali(d)
{
    var jalali = jd_to_persian(gregorian_to_jd(d[0], d[1] + 1, d[2]));
    
    jalali[1]--;
    jalali[2]++;
    if((jalali[1]<7 && jalali[2]>31) || jalali[1]>6 && jalali[2]>30)
    {
         jalali[1]++;
         jalali[2]=1;

    }
    
    
    
    if(jalali[1]<10)
    {
        jalali[1]='0'+jalali[1];

    }
    if(jalali[2]<10)
    {
        jalali[2]='0'+jalali[2];

    }
    return jalali;
}
//------------------------------------------------------------------------------
function hijriTOgregorian(d) 
{
    var gregorian = jd_to_gregorian(islamic_to_jd(d[0], d[1] + 1, d[2]));
    gregorian[1]--;
    gregorian[2]++;
    if(gregorian[1]<10)
    {
        gregorian[1]='0'+gregorian[1];

    }
    if(gregorian[2]<10)
    {
        gregorian[2]='0'+gregorian[2];

    }
    return gregorian;
}
//------------------------------------------------------------------------------
function gregorianTOhijri(d)
{
    var hijri = jd_to_islamic(gregorian_to_jd(d[0], d[1] + 1, d[2]));
    hijri[1]--;
    hijri[2]--;
    if(hijri[1]<10)
    {
        hijri[1]='0'+hijri[1];

    }
    if(hijri[2]<10)
    {
        hijri[2]='0'+hijri[2];

    }
    return hijri;
}
//------------------------------------------------------------------------------
function jalaliTOhijri(d)
{
    var gr=jalaliTOgregorian(d);
    var hijri=gregorianTOhijri([parseInt(gr[0], 10), parseInt(gr[1], 10), parseInt(gr[2], 10)]);
    
    return hijri;
}
//------------------------------------------------------------------------------
function hijriTOjalali(d)
{
    var gr=hijriTOgregorian(d);
    var jalali=gregorianTOjalali([parseInt(gr[0], 10), parseInt(gr[1], 10), parseInt(gr[2], 10)]);
    
    return jalali;
}