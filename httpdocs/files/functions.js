var url = window.location.host;

function showSubmenu(id)
{
    $("#sublinks ul").hide();
    $("#s" + id).show();
    return false;
}

function showMessageBox(html)
{
    if ($("#synmsg").length > 0)
    {
        changeMessageBox(html);
    }
    else
    {
        $(".mainContent").prepend('<div onclick="$(this).fadeOut(); return false;" id="synmsg" class="syncrossmsg">' + html + ' [ Нажмите, чтобы убрать ]</div>')
    }
}

function changeMessageBox(html)
{
    $("#synmsg").html(html + ' [ Нажмите, чтобы убрать ]');
    $("#synmsg").show();
}

function decrementTicketCount() {
    var $count = $('#supportTicketCount');
    if (!$count.length) {
        return;
    }
    var iCount = $count.attr('data-count') - 1;
    $count.attr('data-count', iCount);
    if (iCount > 0) {
        $count.html('(+' + iCount + ')');
    }
    else {
        $count.html('');
    }
}

function hideMessageBox()
{
    $("#synmsg").fadeOut();
}

function selectAll(pattern)
{
    $(":checkbox[id*='" + pattern + "']").attr("checked", "checked");
}

function deselectAll(pattern)
{
    $(":checkbox[id*='" + pattern + "']").removeAttr("checked");
}