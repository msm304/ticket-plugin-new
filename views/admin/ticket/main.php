<?php
$department_manager = new TKT_Admin_Department_Manager();
$parent_departments = $department_manager->get_parent_department();
$stauses = tkt_get_status();
?>
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
                                <span class="count">(24)</span>
                            </a>
                        </li>
                        <?php foreach ($stauses as $item) : ?>
                            <li class="<?php echo $item['slug'] ?>">
                                <a href="" class="current" style="color: <?php echo $item['color'] ?>;">
                                    <?php echo esc_html($item['name']) ?>
                                    <span class="count">24</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
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
                                <?php if (count($parent_departments)) : ?>
                                    <?php foreach ($parent_departments as $parent) : ?>
                                        <optgroup label="<?php echo esc_attr($parent->name) ?>">
                                            <?php $child_department = $department_manager->get_child_department($parent->ID) ?>
                                            <?php if (count($child_department)) : ?>
                                                <?php foreach ($child_department as $child) : ?>
                                                    <option value="<?php echo $child->ID ?>"><?php echo esc_html($child->name); ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>

                            <select name="priority">
                                <option value="">تمام اولویت ها</option>
                                <option value="low">کم</option>
                                <option value="meduim">متوسط</option>
                                <option value="high">زیاد</option>
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
                        <?php
                        $this->ticket_object->prepare_items();
                        $this->ticket_object->display();
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>