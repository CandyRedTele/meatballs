var col=null, numerical=false, direction=1;

function sortTable(c, n, d)
{   if ( col==c && Number(d)==direction )
         return;               // already sorted by column c
    col=c;                     // set column position
    direction = Number(d);
    numerical = (n == "num");
    var list = document.getElementById("thelist");
    var r = list.childNodes;


	

    n = r.length;
    var arr = new Array(n-1);
    for(i=1; i < n; i++){
        arr[i-1]=r.item(i);
    }




    quicksort(arr, 0, n-2);
    for(i=0; i < n-1; i++) list.appendChild(arr[i]);
}

function key(r, c)
{   var cell = r.firstChild;
    while ( c > 0 )
    {  cell = cell.nextSibling;
       c--;
    }
    return cell.firstChild.nodeValue;
}

function compare(r1, r2)
{   ke1 =  key(r1, col);   // col global variable
    ke2 =  key(r2, col);
    if ( numerical )
    {   ke1 = Number(ke1);
        ke2 = Number(ke2);
        return direction * (ke1 - ke2);
    }
    return (direction * strCompare(ke1, ke2));
}

function strCompare(a, b)
{   var m = a.length;
    var n = b.length;
    var i = 0;
    if ( m==0 && n==0 ) return 0;
    if ( m==0 ) return -1;
    if ( n==0 ) return 1;
    for ( i=0; i < m && i < n; i++ )
    {   if ( a.charAt(i) < b.charAt(i) ) return -1;
        if ( a.charAt(i) > b.charAt(i) ) return 1;
    }
    return (m - n);
}

function quicksort(arr, l, h)
{   // window.alert("sort " + l + " " + h );
    if ( l >= h || l < 0 || h < 0 ) return;
    if ( h - l == 1 )
    {   if (compare(arr[l], arr[h]) > 0)
        {  swap(arr, l, h)   }
        return;
    }

    var k = partition(arr, l, h);

		
	//document.getElementById("testing").innerHTML = "111111111111";
    var k = partition(arr, l, h);
	//document.getElementById("testing").innerHTML = "999999999999";

    quicksort(arr, l, k-1);
    quicksort(arr, k+1, h);
}

function partition(arr, l, h)
{   var i=l, j=h;
    swap(arr, ((i+j)+(i+j)%2)/2, h);
    var pe = arr[h];

    while (i < j)
    {  while (i < j && compare(arr[i], pe) < 1)
       {  i++; }   // from left side
       while (i < j && compare(arr[j], pe) > -1)
       {  j--; }   // from right side
       if (i < j) {  swap(arr, i++, j); }
    }

	//document.getElementById("testing").innerHTML = "222222222222";
    while (i < j)
    {  
		while (i < j && compare(arr[i], pe) < 1)
       {  i++; }   // from left side
	   //document.getElementById("testing").innerHTML = "333333333333";
       while (i < j && compare(arr[j], pe) > -1)
       {  j--; }   // from right side
	   //document.getElementById("testing").innerHTML = "444444444444";
       if (i < j) {  swap(arr, i++, j); }
	   //document.getElementById("testing").innerHTML = "555555555555";
    }
	

    if (i != h) swap(arr, i, h);
    return i;
}

function swap(arr, i, j)
{   var tmp = arr[i];
    arr[i]=arr[j];
    arr[j]=tmp;
}
