<div class="tkt-tickets wrap">
    <h1 class="wp-heading-inline">تیکت ها</h1>
    <a href="?page=tkt-new-ticket" class="page-title-action">ارسال تیکت جدید</a>

    <!-- <span class="subtitle">نتایج جستجو برای: کلمه جستجو شده</span> -->

    <hr class="wp-header-end">
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <ul class="subsubsub">
                        <li class="all">
                            <a href="admin.php?page=tkt-tickets" class="current">
                                همه
                                <span class="count"></span>
                            </a>
                        </li>
                        <li class="<?php echo $item['slug'] ?>">
                            <a href="admin.php?page=tkt-tickets&status=<?php echo $item['slug'] ?>" class="current" style="color: <?php echo $item['color'] ?>;">
                                <span class="count"></span>
                            </a>
                        </li>

                    </ul>
                    <br class="clear">
                    <form method="get">
                        <div class="filter-box">

                            <input type="hidden" name="page" value="<?php echo $page ?>">

                            <select name="department-id">
                                <option value="">تمام دپارتمان ها</option>

                                <optgroup label="<?php echo esc_attr($parent->name) ?>">
                                    <option <?php selected($department_id, $child->ID) ?> value="<?php echo $child->ID ?>"><?php echo esc_html($child->name); ?></option>
                                </optgroup>

                            </select>

                            <select name="priority">
                                <option value="">تمام اولویت ها</option>
                                <option <?php selected($priority, 'low') ?> value="low">کم</option>
                                <option <?php selected($priority, 'medium') ?> value="medium">متوسط</option>
                                <option <?php selected($priority, 'high') ?> value="high">زیاد</option>
                            </select>

                            <select id="tkt-creator-id" name="creator-id">
                            </select>

                            <input type="search" name="search" value="<?php echo $search ?>" placeholder="جستجو">
                            <input type="submit" id="search-submit" class="button" value="فیلتر">
                        </div>
                    </form>

                    <!-- <form method="post" onsubmit="">
                            <input type="submit" id="delete-all" name="delete-all" class="button" value="خالی کردن زباله دان">
                    </form> -->

                    <form method="post">

                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>