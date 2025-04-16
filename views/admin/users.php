<div class="page-heading">
  <h3>Manage Users</h3>
</div>

<script>
const users = <?= json_encode($data['paginated_users']) ?>;
const users_count = <?= json_encode($data['users_count']) ?>;
console.log(users)
console.log(users_count)
</script>