// SelectInput.jsx
import { forwardRef, useRef, useEffect } from "react";

export default forwardRef(function SelectInput(
  { className = "", children, value, ...props },
  ref
) {
  const input = ref ? ref : useRef();

  // Log the value prop on component update
  useEffect(() => {
    console.log("Value prop in SelectInput:", value);
  }, [value]);

  return (
    <select
      {...props}
      className={
        "border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm " +
        className
      }
      ref={input}
      value={value} // Ensure that the value prop is correctly assigned
      onChange={(e) => props.onChange(e)} // Pass onChange event to parent component
    >
      {children}
    </select>
  );
});
