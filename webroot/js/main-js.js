$(function() {

    // Left Panel Menu
    // $( "#tests-menu" ).accordion();
    var treeOptions = {
        data: testsTree,
        enableLinks: true,
        color: 'blue'
    };
    // TODO selecteble test
    // $('#treeTests').treeview('collapseAll', { silent: true });
    $( "#treeTests" ).treeview(treeOptions);
    console.log('main-js');

    // Menu end

    /* Answer add */
    var numAnswer = 1;
    $( "#add-answer" ).click(function() {
        var checkbox = $("#answer-list div.form-group:last-child input[name='answer_true[]']");
        var newInput = '';
        newInput += '<div class="form-group row">'
        newInput += '<div class="col-sm-1">';
        newInput += '<input type="checkbox" name="answer_true[]" value="'+ (+checkbox.val() + 1) +'">';
        newInput += '</div>';
        newInput += '<div class="col-sm-11">';
        newInput += '<textarea  class="form-control" name="answer[]"></textarea>';
        newInput +=  '</div>';
        newInput += '</div>';

        $( "#answer-list" ).append(newInput);

        $( "#remove-answer" ).show();

    });

    $( "#remove-answer" ).click(function() {
        var answerList = $("#answer-list div.form-group");
        if (answerList.length > 1) {
            $("#answer-list div.form-group:last-child").remove();
            --numAnswer;
        }
        if (answerList.length <= 2) {
            $("#remove-answer").hide();
        }
    });

});/**
 * Created by litter on 04.05.16.
 */
