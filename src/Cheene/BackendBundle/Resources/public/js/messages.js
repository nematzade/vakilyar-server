function toFaNum (str) {
    persianNumberMapper = function(num) { return ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'][num]; }

    return String(str).replace(/\d/g, persianNumberMapper);
}

messageQueue = {
    messageTable: $('#message_table'),
    filter:{
        currentPage: 0,
        numberOfPages: 0,
        pageSize: 50,

        searchValue: null,
        isVendorSearch: null,

        messageId: null,
        messageType: 'all',
        receiverType: null
    },

    counts: {
        totalMessages: 0 ,
        queuedMessagesCount: 0 ,
        sentMessagesCount: 0 ,
        // smsMessagesCount: 0 ,
        // emailMessagesCount: 0,
        // pushMessagesCount: 0
    },
    init: function() {
        $('.clear-filters').hide();
        messageQueue.loadMessages('all');
        messageQueue.filterHandler();
        messageQueue.eventHandler();
    },


    emptySearchFields: function () {
        $('#searchBox').val('');
        $('#searchBox').empty();
        $('#isVendorSearch').prop("checked", false);
        $('#isVendorSearch').attr('checked', false);
        messageQueue.filter.messageId = '';
        messageQueue.filter.searchValue = null;
        messageQueue.filter.isVendorSearch = null;
        $('.clear-filters').hide();
    },

    latestMessageType: '',
    loadMessages: function(lastMessageType) {
        $('.main-loader').fadeIn(300);
        $.ajax({
            url: Routing.generate('backend_communication_job_index'),
            cache: false,
            type: 'GET' ,
            data:{
                filter: messageQueue.filter
            }
        })
        .done(function(data) {
            var messages = data['messages'];
            messageQueue.messageTable.find('.messages-row').remove();
            for (var i = 0; i < data['messages'].length; i++) {
                messageQueue.addMessageRow(messages[i], parseInt(data['count'])-parseInt(messageQueue.filter.pageSize * messageQueue.filter.currentPage+parseInt(i)), data.messageCount);
            }

            messageQueue.counts.totalMessages            = parseInt(data['count']);
            // messageQueue.counts.queuedMessagesCount      = parseInt(data['queuedMessagesCount']);
            // messageQueue.counts.sentMessagesCount        = parseInt(data['sentMessagesCount']);
            // messageQueue.counts.smsMessagesCount         = parseInt(data['smsMessagesCount']);
            // messageQueue.counts.emailMessagesCount       = parseInt(data['emailMessagesCount']);
            // messageQueue.counts.pushMessagesCount        = parseInt(data['pushMessagesCount']);

            $('.all-messages-count').empty();       $('.all-messages-count').append(messageQueue.counts.totalMessages);
            // $('.queued-messages-count').empty();    $('.queued-messages-count').append(messageQueue.counts.queuedMessagesCount);
            // $('.sent-messages-count').empty();      $('.sent-messages-count').append(messageQueue.counts.sentMessagesCount);
            // $('.sms-messages-count').empty();       $('.sms-messages-count').append(messageQueue.counts.smsMessagesCount);
            // $('.email-messages-count').empty();     $('.email-messages-count').append(messageQueue.counts.emailMessagesCount);
            // $('.push-messages-count').empty();      $('.push-messages-count').append(messageQueue.counts.pushMessagesCount);

            var init = (messageQueue.latestMessageType != lastMessageType? true: false);
            if (lastMessageType == 'all')  {
                messageQueue.paginationHandler(messageQueue.counts.totalMessages, init);
            }
            // if (lastMessageType == 'queued')  {
            //     messageQueue.paginationHandler(messageQueue.counts.queuedMessagesCount, init);
            // }
            // if (lastMessageType == 'sent')  {
            //     messageQueue.paginationHandler(messageQueue.counts.sentMessagesCount, init);
            // }
            // if (lastMessageType == 'sms')  {
            //     messageQueue.paginationHandler(messageQueue.counts.smsMessagesCount, init);
            // }
            // if (lastMessageType == 'email')  {
            //     messageQueue.paginationHandler(messageQueue.counts.emailMessagesCount, init);
            // }
            // if (lastMessageType == 'push')  {
            //     messageQueue.paginationHandler(messageQueue.counts.pushMessagesCount, init);
            // }
            messageQueue.latestMessageType = lastMessageType;
        }).fail(function() {
            console.log('load failed');
        }).always(function() {
            $('.main-loader').fadeOut(300);
        });
    },

    addMessageRow: function(message, message_index,messageCount) {
        row = messageQueue.messageTable.find('.clonable-row').clone();
        row.removeClass('clonable-row');
        row.attr('data-clonable', false);
        row.removeClass('hide');
        row.addClass('messages-row');
        if (message['status'] == 'QUEUED') {
            row.removeClass('confirmed').addClass('rejected');
        } else {
            row.removeClass('rejected').addClass('confirmed');
        }
        row.find('td[data-field="rowId"]').html(message_index);
        row.find('td[data-field="messageId"]').html(message['id']);
        row.find('td[data-field="title"]').html(message['title']);
        row.find('td[data-field="status"]').html(message['status']);
        row.find('td[data-field="messageType"]').html(message['messageType']);
        row.find('td[data-field="receiverType"]').html(message['receiverType']);
        row.find('td[data-field="receiverId"]').html(message['receiverId']);
        row.find('td[data-field="messageBox"]').html('<a class="view-message btn btn-xs blue" item-id="'+message['id']+'" ><i class="fa fa-eye" ></i></a>'); // add view sms content button here to view modal
        messageQueue.messageTable.append(row);
    },

    openModalId: -1,
    eventHandler: function () {
        // $(document).on('click', '#communicationjob_datatable .msg-show', function (event) {
        //     event.preventDefault();
        //     var url = $(this).attr('href');
        //     $.get(url,
        //         {}
        //         , function (data, status) {
        //             if(data.status == true) {
        //                 showMessage(data.content);
        //             }
        //         });
        // })
        // $('#myModal .modal-footer').append('<button type="button" class="btn btn-danger green send-modal" >ارسال</button>');
        $(document).on('click', '#message_table .view-message', function (event) {
            var modal = $('#myModal');
            messageQueue.openModalId =  $(this).attr('item-id');
            hr = Routing.generate('backend_communication_get_message');
            $.post(hr,
                {
                    'id': messageQueue.openModalId
                },
                function (data) {
                    modal.find('.modal-body').empty();
                    modal.find('.modal-header').remove();
                    modal.find('.modal-body').html(data);
                    $('#btn-modal').trigger('click');
                });

        });
        // $(document).on('click', '.view-message', function () {
        //     var id = $(this).attr('item-id');
        // });
    },

    showMessage: function(_message) {
        $('#myModal').find('.modal-content').css({'padding':'20px 0'}).html(_message);
        $('#btn-modal').trigger('click');
    },

    filterHandler: function(){
        $('.messages-pagination').on('click', '.page-num', function(){
            $('.page-num').removeClass('selected');
            $(this).addClass('selected')
            messageQueue.filter.currentPage = parseInt($(this).data('page'));
            messageQueue.loadMessages(messageQueue.latestMessageType);
        });

        $('#searchBox').on('keyup', function(e){
            if (e.keyCode == 13) {
                var isVendor = null;
                if( $('#isVendorSearch').is(":checked")){
                    isVendor = 1;
                } else {
                    isVendor = 0;
                }
                messageQueue.filter.isVendorSearch = isVendor;
                messageQueue.filter.searchValue = $('#searchBox').val();
                messageQueue.loadMessages('all');
                // $('.clear-filters').show();
                $('.clear-filters').show();
            }
        });

        $('.clear-filters').on('click',function () {
            messageQueue.emptySearchFields();
            messageQueue.loadMessages('all');
        })



        // $('.messages-navigation-bar').on('click', '.show-queued-messages', function(){
        //     messageQueue.filter.messageType = 'queued';
        //     messageQueue.loadMessages('queued');
        // });
        //
        //
        // $('.messages-navigation-bar').on('click', '.show-sent-messages', function(){
        //     messageQueue.filter.messageType = 'sent';
        //     messageQueue.loadMessages('sent');
        // });


        // $('.messages-navigation-bar').on('click', '.show-sms-messages', function(){
        //     messageQueue.filter.messageType = 'sms';
        //     messageQueue.loadMessages('sms');
        // });

        // $('.messages-navigation-bar').on('click', '.show-email-messages', function(){
        //     messageQueue.filter.messageType = 'email';
        //     messageQueue.loadMessages('email');
        // });
        //
        // $('.messages-navigation-bar').on('click', '.show-push-messages', function(){
        //     messageQueue.filter.messageType = 'push';
        //     messageQueue.loadMessages('push');
        // });


    },

    paginationHandler: function(messageCount, _init) {
        if (_init == null) {
            _init = false;
        }
        if (_init) {
            messageQueue.filter.currentPage = 0;
        }
        $('.messages-pagination').empty();
        messageQueue.filter.numberOfPages = Math.ceil(messageCount/messageQueue.filter.pageSize);
        selected = '';
        var activePage = parseInt(messageQueue.filter.currentPage);
        var totalPages = parseInt(messageQueue.filter.numberOfPages);
        // alert(messageCount);

        if (parseInt(activePage-1) >= 0) {
            $('.messages-pagination').append('<span class="page-num" data-page="' + parseInt(activePage - 1) + '">قبلی</span>');
        }
        $('.messages-pagination').append('<span class="page-num '+selected+'" data-page="'+parseInt(activePage)+'">'+parseInt(activePage+1)+'</span>');

        if (parseInt(activePage+1) < totalPages) {
            $('.messages-pagination').append('<span class="page-num" data-page="' + parseInt(activePage + 1) + '">بعدی</span>');
        }
    }
};