import request from "@/utils/request";

export const getUsers = params => {
  return request({
    url: "/users",
    method: "get",
    params
  });
};

export const createUser = data => {
  return request({
    url: "/users",
    method: "post",
    data
  });
};

export const deleteUser = param => {
  return request({
    url: "/users/" + param,
    method: "delete"
  });
};

export const showUser = param => {
  return request({
    url: "/users/" + param,
    method: "get"
  });
};

export const updateUser = data => {
  return request({
    url: "/users/" + data.id,
    method: "put",
    data
  });
};

export const requestSendMail = data => {
  return request({
    url: "/reset-password",
    method: "post",
    data
  });
};

export const resetPassword = data => {
  return request({
    url: "/reset-password/" + data.token,
    method: "put",
    data
  });
};
