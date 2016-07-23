<script>
var world_cities = {!! $world_cities !!};
var country_id = null;
var province_id = null;
var city_id = null;

function setCountry()
{
    $('#country').html('<option value="">{{trans("messages.select_country")}}</option>');
    $.each(world_cities,function(key,value){
        $('#country').append('<option value="'+key+'">'+value.name+'</option>');
        $('#country').val(country_id);
    })
}
function setProvince()
{
    $('#province').html('<option value="">{{trans("messages.select_porvince")}}</option>');
    if( world_cities[country_id] ){
        $.each(world_cities[country_id].provinces,function(key,value){
            $('#province').append('<option value="'+key+'">'+value.name+'</option>');
            if( province_id ){
                $('#province').val(province_id);
            }

        })
    }
}
function setCity()
{
    $('#city').html('<option value="">{{trans("messages.select_city")}}</option>');
    if( world_cities[country_id].provinces[province_id] ){
        $.each(world_cities[country_id].provinces[province_id].cities,function(key,value){
            $('#city').append('<option value="'+key+'">'+value.name+'</option>');
            if( city_id ){
                $('#city').val(city_id);
            }

        })
    }
}

</script>
