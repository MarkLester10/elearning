new Vue({
  el: "#app",
  data: {
    subjects: [],
    department_id: "",
    url: "http://localhost/lms/app/controllers/admin/FacultyController.php",
  },
  methods: {
    getSubjects: function () {
      axios
        .get(
          `http://localhost/lms/app/controllers/admin/FacultyController.php?dept_id=${this.department_id}`
        )
        .then((res) => (this.subjects = res.data.subjects));
    },
  },
  mounted: function () {},
});
