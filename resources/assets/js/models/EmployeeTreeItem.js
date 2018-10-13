module.exports = function EmployeeTreeItem({isLeaf, children_count, id, lft, rgt, firstname, middlename, lastname, depth, salary, position, paent, parent_id, employed_at, children}) {
    this.id = id;
    this.firstname = firstname;
    this.middlename = middlename;
    this.lastname = lastname;
    //this.children = children;
    this.depth = depth;
    this.salary = salary;
    this.lft = lft;
    this.rgt = rgt;
    this.parent_id = parent_id;
    this.employed_at = employed_at;
    this.position = position;
    this.parent = parent;
    this.isLeaf = isLeaf;
    this.children_count = children_count;
}