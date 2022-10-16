$('#select-gantt').on('click', () => {
    $('#select-gantt').addClass('bg-primary text-white');
    $('#select-add').removeClass('bg-primary text-white');
    $('#select-detail').removeClass('bg-primary text-white');
    $('#chart_div').slideDown();
    $('#board').slideUp();
});

$('#select-add').on('click', () => {
    $('#select-add').addClass('bg-primary text-white');
    $('#select-gantt').removeClass('bg-primary text-white');
    $('#select-detail').removeClass('bg-primary text-white');
    $('#chart_div').slideUp();
    $('#board').slideDown();
});
$('#select-detail').on('click', () => {
    getData();
});
$('#select-subtask').on('click', () => {
    goSubtask();
});
$('#select-home').on('click', () => {
    goToPostTask();
});
