
/**
 * 分页控件
 * by eu3 2009-11-03
 * @param {Object} id
 */
Pagination = function (id) {
    var totalNum = 0;
    var maxNum = 10;
    var pageUrl = "";
    var breakpage = 5;
    var currentposition = 3;
    var breakspace = 2;
    var maxspace = 4;
    var currentpage = 1;
    var perpage = 10;
    var id = id;
    var pagecount = 0;

    this.setStep = function (step) {
        currentposition = step;
    };

    this.getPages = function () {
        return pagecount;
    };

    this.initPage = function (pageName) {
        var count = this.getTotalNum();
        perpage = this.getMaxNum();
        if (currentpage == null) {
            currentpage = 1;
        } else {
            currentpage = parseInt(currentpage);
        }

        pagecount = Math.floor(count / perpage) + 1;
        var pagestr = "";
        var prevnum = currentpage - currentposition;
        var nextnum = currentpage + currentposition;
        if (prevnum < 1)
            prevnum = 1;
        if (nextnum > pagecount)
            nextnum = pagecount;
        pagestr += (currentpage == 1) ? '<span class="disabled">上一页</span>' : '<span><a  href="javascript:' + pageName + '.page_onclick(' + (this.getIndexPage() - 1) + ',\'' + pageName + '\')">上一页</a></span>';

        if (prevnum - breakspace > maxspace) {
            for (var i = 1; i <= breakspace; i++)
                pagestr += '<a href="javascript:' + pageName + '.page_onclick(' + i + ',\'' + pageName + '\')">' + i + '</a>';
            pagestr += '....';
            for (var i = pagecount - breakpage + 1; i < prevnum; i++)
                pagestr += '<a href="javascript:' + pageName + '.page_onclick(' + i + ',\'' + pageName + '\')">' + i + '</a>';
        } else {
            for (var i = 1; i < prevnum; i++)
                pagestr += '<a href="javascript:' + pageName + '.page_onclick(' + i + ',\'' + pageName + '\')">' + i + '</a>';
        }

        for (var i = prevnum; i <= nextnum; i++) {
            pagestr += (currentpage == i) ? '<span class="current">' + i + '</span>' : '<a href="javascript:' + pageName + '.page_onclick(' + i + ',\'' + pageName + '\')">' + i + '</a>';
        }

        if (pagecount - breakspace - nextnum + 1 > maxspace) {
            for (var i = nextnum + 1; i <= breakpage; i++)
                pagestr += '<a href="javascript:' + pageName + '.page_onclick(' + i + ',\'' + pageName + '\')">' + i + '</a>';
            pagestr += '<span class="break">....</span>';
            for (var i = pagecount - breakspace + 1; i <= pagecount; i++)
                pagestr += '<a href="javascript:' + pageName + '.page_onclick(' + i + ',\'' + pageName + '\')">' + i + '</a>';
        } else {
            for (var i = nextnum + 1; i <= pagecount; i++)
                pagestr += '<a href="javascript:' + pageName + '.page_onclick(' + i + ',\'' + pageName + '\')">' + i + '</a>';
        }

        pagestr += (currentpage == pagecount) ? '<span class="disabled">下一页</span>' : '<a href="javascript:' + pageName + '.page_onclick(' + (this.getIndexPage() + 1) + ',\'' + pageName + '\')">下一页</a>';

        //
        //pagestr += ' &nbsp; <input type="text" id="tpagenum">';
        //var tempage = this.$geb("tpagenum");
        //tempage = (null==tempage)?1:tempage.value;
        //pagestr += '<a href="javascript:'+pageName+'.page_onclick('+tempage+',\''+pageName+'\')">GO</a>';

        this.$geb(id).className = "manu";
        this.$geb(id).innerHTML = pagestr;
    };

    this.getTotalNum = function () {
        return totalNum;
    };

    this.setTotalNum = function (sTotalNum) {
        totalNum = sTotalNum;
    };

    this.getMaxNum = function () {
        return maxNum;
    };

    this.setMaxNum = function (sMaxNum) {
        maxNum = sMaxNum;
    };

    this.getIndexPage = function () {
        return currentpage;
    };

    this.setIndexPage = function (sCurrentPage) {
        currentpage = sCurrentPage;
    };

    this.page_onclick = function (num, pageStr) {
        this.setIndexPage(num);
        pagination_data();
        //this.initPage(pageStr);
    };

    this.$geb = function (objStr) {
        return document.getElementById(objStr);
    };

}

function $geb(objStr) {
    return document.getElementById(objStr);
}

//function pagination_data(){

//}










