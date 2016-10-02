var SupportTicketComplaint = Backbone.View.extend({
    prefix: 'supportTicketComplaint',

    events: {
        "submit #supportTicketComplaintForm": "submit"
    },

    show: function (event) {
        this.$el.find('.message-content').hide();
        this.$el.find('.main-content').show();
        this.$el.find('form').trigger('reset');
        KMA.modalShow(this.$el);
        return false;
    },

    submit: function (event) {
        event.preventDefault();
        var formData = $(event.currentTarget).serializeObject();
        var $element = this.$el;
        KMA.makeRequest(
            '/support/ticket/complaint',
            formData,
            'json',
            function (data) {
                if (KMA.isset(data.result) && (data.result == 1)) {
                    var $message = $element.find('.message-content');
                    $message.html(data['html']);
                    $message.show();
                    $element.find('.main-content').hide();
                }
            },
            'supportTicket.complaintAdd'
        );
    },

    render: function () {
        this.setElement($('#quality-control'));
        return this;
    }
});
supportTicketComplaint = new SupportTicketComplaint();
$(document).ready(function(){
    supportTicketComplaint.render();
});