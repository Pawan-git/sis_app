<style>
.sidenav {
  height: 100%;
  width: 0;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  transition: 0.5s;
}
.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}
</style>

<div class="sidenav">
  <a href="<?php echo base_url('admin');?>">Dashboard</a>
  <a href="<?php echo base_url('admin/monthwise-expense');?>">Monthly Expenses</a>
  <a href="<?php echo base_url('admin/user-list');?>">Users</a>
</div>