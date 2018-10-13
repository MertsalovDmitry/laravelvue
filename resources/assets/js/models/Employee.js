module.exports = function Employee({id, lft, rgt, firstname, middlename, lastname, depth, salary, position, parent_id, employed_at}) {
    this.id = id;
    this.firstname = firstname;
    this.middlename = middlename;
    this.lastname = lastname;
    this.depth = depth;
    this.salary = salary;
    this.lft = lft;
    this.rgt = rgt;
    this.parent_id = parent_id;
    this.employed_at = employed_at;
    this.position = position;
}