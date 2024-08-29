import React, { useState } from "react";
import { Inertia } from "@inertiajs/inertia";

const VerifyEmail = ({ status, verificationNoticeRoute }) => {
  const [resending, setResending] = useState(false);

  const handleResendVerification = () => {
    setResending(true);
    Inertia.post(
      verificationNoticeRoute,
      {},
      {
        onFinish: () => setResending(false),
        onError: () => setResending(false),
      }
    );
  };

  return (
    <div className="flex justify-center items-center h-screen">
      <div className="max-w-lg mx-auto p-6 bg-gray-900 shadow-md rounded-lg text-white text-center">
        <h1 className="text-3xl font-bold mb-4">Verify Your Email Address</h1>
        <p className="mb-6 text-gray-400 leading-relaxed">
          Thanks for signing up! Before getting started, could you verify your
          email address by clicking on the link we just emailed to you? If you
          didn't receive the email, we will gladly send you another.
        </p>
        {status === "verification-link-sent" && (
          <div className="mb-4 p-3 bg-green-500 text-white border border-green-600 rounded">
            A new verification link has been sent to your email address.
          </div>
        )}
        <button
          className={`px-4 py-2 rounded text-white ${
            resending
              ? "bg-gray-600 cursor-not-allowed"
              : "bg-blue-600 hover:bg-blue-700"
          }`}
          onClick={handleResendVerification}
          disabled={resending}
        >
          {resending ? "Resending..." : "Resend Verification Email"}
        </button>
      </div>
    </div>
  );
};

export default VerifyEmail;
