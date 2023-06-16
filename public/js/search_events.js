import * as utils from './utils.js';

$(document).ready(function () {
    const customerID = parseInt($('#customer_id').val());
    let txtSearch = '';

    const populate = (item) => {
        const eventDetailsURL = `user/showEvent/${item.id}`;
        // const bookingExists = item.bookingEixsts;


        $('#search_results').append(`
            <div class="col-sm-6 pt-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize">${item.event_title} </h5>                     
                        <p>${item.adult_supervision === 'Y' ? utils.adultSupervision() : ''}</p>                     
                        <h6>${utils.formatDate(item.event_date)} ${utils.formatTime(item.start_time)} - ${utils.formatTime(item.end_time)}</h6>
                        <p class="card-text">${item.event_description}</p>
                        ${utils.renderBuyButton(customerID, eventDetailsURL )}
                    </div>
                </div>
            </div>               
        `);
    }
    // user/showEvent/${item.id}


    const populateSearchUI = (items) => {

        if (!items.length) {

            $('#search_results').html(utils.setMessage('No events found'));
            return;
        }

        items.forEach(item => populate(item));

    };

    const getSearchResults = () => {

        $.ajax({

            url: $('#searchRoute').val(),
            data: {
                txtSearch: txtSearch
            },
            // dataType: 'json',
            success: (responseData) => {

                // console.log({responseData});

                $('#search_results').html(responseData)

                //
                // if ($.trim($('#search_results').html()).length > 0) $('#search_results').html('');
                // populateSearchUI(responseData);
            }
        });
    }

    getSearchResults();

    $('#search').on('keyup search', function () {
        txtSearch = $(this).val();
        getSearchResults();

    });

    // prevent form submission
    $(document).on('submit', '#productsSearchForm', () => false);
    // $('.eventsBtn').click(function (){
    //     alert('d')
    // })


});