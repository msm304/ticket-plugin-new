<div class="tkt-wrap tkt-all-tickets">

    <header class="tkt-panel-header tkt-clearfix">
        <h4>همه تیکت ها</h4>

        <a href="<?php echo TKT_Ticket_Url::new(); ?>" class="tkt-new-ticket tkt-btn tkt-btn-success tkt-btn-small">تیکت جدید</a>
    </header>

    <div class="tkt-statues-box">
        <div class="tkt-row">


            <div class="tkt-status-item tkt-status-item-all tkt-col">
                <div>
                    <div class="tkt-status-icon">
                        <img src="<?php echo TKT_FRONT_ASSETS . 'images/' ?>ticket.png" width="32" height="32" alt="ticket">
                        <span style="background: red;"></span>
                    </div>
                    <div class="tkt-status-name">باز</div>
                    <div class="tkt-status-count" style="color: red;">35</div>
                </div>
            </div>

            <div class="tkt-status-item tkt-status-item-open tkt-col">
                <div>
                    <div class="tkt-status-icon">
                        <img src="<?php echo TKT_FRONT_ASSETS . 'images/' ?>ticket.png" width="32" height="32" alt="ticket">
                        <span></span>
                    </div>
                    <div class="tkt-status-name">همه</div>
                    <div class="tkt-status-count" style="color: red;">100</div>
                </div>
            </div>
        </div>
    </div>


    <div class="tkt-filter-container tkt-clearfix">
        <form id="tkt-filter" method="get" action="">
            <select class="tkt-ticket-type tkt-custom-select" name="type">
                <option value="all">همه</option>
                <option value="sent">فرستاده شده</option>
                <option value="received">دریافتی</option>
            </select>
            <select class="tkt-ticket-status tkt-custom-select" name="status">
                <option value="all">همه</option>
            </select>
            <select class="tkt-orderby tkt-custom-select" name="orderby">
                <option value="reply-date">تاریخ پاسخ</option>
                <option value="create-date">تاریخ ایجاد</option>
            </select>
            <input type="submit" class="tkt-filter tkt-btn tkt-btn-secondary" value="فیلتر">
        </form>
        <span class="tkt-total-count">نمایش ۴۵ تیکت</span>

    </div>


    <div class="tkt-tickets-list">

        <div class="tkt-ticket-item" id="tkt-ticket-45">

            <div class="tkt-item-title">
                <div class="tkt-item-inner">

                    <a href="" class="tkt-ticket-title"></a>

                    <div>

                        <div class="tkt-ticket-department">
                            <img src="menu.svg" width="12" height="12" alt="menu">
                            <span class="tkt-department"></span>
                        </div>

                    </div>
                </div>
            </div>


            <div class="tkt-item-user">
                <div class="tkt-item-inner">
                    <span class="tkt-creator"></span>

                </div>
            </div>


            <div class="tkt-ticket-item-abs">

                <div class="tkt-reply-count tkt-reply-12">
                    <img src="message.svg" width="20" height="20" alt="message">

                </div>

            </div>


            <div class="tkt-item-date">
                <div class="tkt-item-inner">

                    <div class="tkt-date" dir="ltr"></div>

                </div>
            </div>


            <div class="tkt-item-actions">
                <div class="tkt-item-inner">
                    <a href="" class="tkt-btn tkt-btn-secondary tkt-btn-small">مشاهده تیکت</a>
                </div>
            </div>

        </div>

    </div>


    <div class="tkt-alert tkt-alert-danger">
        <p>هیچ تیکتی یافت نشد</p>
    </div>



</div>