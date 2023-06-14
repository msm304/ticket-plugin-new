<?php

$user_id = get_current_user_id();

$type = $_GET['type'] ? $_GET['type'] : 'all';
$status = $_GET['status'] ? $_GET['status'] : 'all';
$orderby = $_GET['orderby'] ? $_GET['orderby'] : 'reply-date';

$ticket_manager = new TKT_Ticket_Manager();
$tickets = $ticket_manager->get_tickes($user_id, $type, $status, $orderby);

$department_manager = new TKT_Front_Department_Manager();

$statuses = tkt_get_status();
?>
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
                <option value="send" <?php selected($type, 'send') ?>>فرستاده شده</option>
                <option value="received" <?php selected($type, 'received') ?>>دریافتی</option>
            </select>
            <select class="tkt-ticket-status tkt-custom-select" name="status">
                <option value="all" <?php selected($status, 'all') ?>>همه</option>
                <?php foreach ($statuses as $_status) : ?>
                    <option <?php selected($status, $_status['slug']) ?> value="<?php echo $_status['slug'] ?>"><?php echo $_status['name'] ?></option>
                <?php endforeach ?>
            </select>
            <select class="tkt-orderby tkt-custom-select" name="orderby">
                <option <?php selected($orderby, 'reply-date') ?> value="reply-date">تاریخ پاسخ</option>
                <option <?php selected($orderby, 'create-date') ?> value="create-date">تاریخ ایجاد</option>
            </select>
            <input type="submit" class="tkt-filter tkt-btn tkt-btn-secondary" value="فیلتر">
        </form>
        <span class="tkt-total-count">نمایش ۴۵ تیکت</span>

    </div>

    <?php if ($tickets) : ?>
        <?php foreach ($tickets as $ticket) : ?>
            <div class="tkt-tickets-list">
                <div class="tkt-ticket-item" id="tkt-ticket-45">

                    <div class="tkt-item-title">
                        <div class="tkt-item-inner">

                            <a href="<?php echo TKT_Ticket_Url::single($ticket->ID) ?>" class="tkt-ticket-title"><?php echo esc_html($ticket->title) ?></a>

                            <div>

                                <div class="tkt-ticket-department">
                                    <img src="<?php echo TKT_FRONT_ASSETS . 'images/' ?>menu.svg" width="12" height="12" alt="menu">
                                    <?php $department = $department_manager->get_department($ticket->department_id); ?>
                                    <span class="tkt-department"><?php echo esc_html($department->name) ?></span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tkt-item-user">
                        <div class="tkt-item-inner">
                            <?php
                            $user_data = get_userdata($ticket->creator_id);
                            ?>
                            <span class="tkt-creator"><?php echo $user_data->display_name ?></span>

                        </div>
                    </div>

                    <div class="tkt-ticket-item-abs">

                        <div class="tkt-reply-count tkt-reply-12">
                            <img src="<?php echo TKT_FRONT_ASSETS . 'images/' ?>message.svg" width="20" height="20" alt="message">
                            <span>12</span>
                        </div>

                    </div>

                    <div class="tkt-item-date">
                        <div class="tkt-item-inner">

                            <div class="tkt-date" dir="ltr"><?php echo tkt_format_date(strtotime($ticket->create_date)); ?></div>

                        </div>
                    </div>

                    <div class="tkt-item-actions">
                        <div class="tkt-item-inner">
                            <a href="<?php echo TKT_Ticket_Url::single($ticket->ID) ?>" class="tkt-btn tkt-btn-secondary tkt-btn-small">مشاهده تیکت</a>
                        </div>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    <?php else : ?>
        <div class="tkt-alert tkt-alert-danger">
            <p>هیچ تیکتی یافت نشد</p>
        </div>
    <?php endif; ?>

</div>