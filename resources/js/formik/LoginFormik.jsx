import React from "react";
import { useFormik } from "formik";
import loginSchema from "../yup/loginSchema";

const LoginFormik = ({ onSubmit, status, canResetPassword }) => {
  const formik = useFormik({
    initialValues: {
      email: "",
      password: "",
      remember: false,
    },
    validationSchema: loginSchema,
    onSubmit: (values) => {
      onSubmit(values);
    },
  });

  return (
    <form onSubmit={formik.handleSubmit}>{/* Your form JSX goes here */}</form>
  );
};

export default LoginFormik;
