<script>

function init(){
    const id = $('[name="id"]').val();
    $.ajax({
        type : 'GET',
        url : "<?php echo base_url("api/news/contents"); ?>/show/"+id,
        dataType : "json",
        success : function(res){  
            let data = res.data;
            const template = $('[data-template="news"]').clone();
            template.removeClass('d-none');
            template.attr('data-template','news-cloned');
            template.find('h3').text(data.title);
            template.find('.kt-widget19__text').html(data.description);
            if(data.cover){
                template.find('.kt-portlet-fit--sides').css('background-image', `url(<?php echo base_url();?>storage/news/${data.cover})`);
            }
            template.find('a').attr('href',`<?php echo base_url('news/detail');?>/${data.id}`);
            if(data.category){
                template.find('a').text(data.category.name);
            }
            $('.append-template').append(template);
        },
        error: function (jqXHR, textStatus, errorThrown){
       }
    });  
}


jQuery(document).ready(function() { 
    init()
});

</script>
