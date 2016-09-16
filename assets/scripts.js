function check_text_area()
{
    var ta_value = document.getElementById('input_string').value.trim();

    if(ta_value.length == 0)
    {
        alert('The first textarea must contain a string!');

        return false;
    }

    return true;
}