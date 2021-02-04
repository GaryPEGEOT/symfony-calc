import React from "react";
import { Formik, Field, ErrorMessage } from "formik";
import axios from "axios";
import { get } from "lodash";
import { ApiResponse } from "../contracts";

declare global {
    interface Window {
        OPERATION_PATTERN: RegExp;
    }
}

type Props = {
    onSubmit: (operation: number) => void;
};

const OPERATION_PATTERN = window.OPERATION_PATTERN;

const Form: React.FC<Props> = ({ onSubmit }) => {
    return (
        <Formik
            initialValues={{ operation: "" }}
            validate={({ operation }) => {
                const errors: Record<string, string> = {};

                if (!operation) {
                    errors.operation = "Required";
                } else if (!OPERATION_PATTERN.test(operation)) {
                    errors.operation = "Invalid format";
                }

                return errors;
            }}
            onSubmit={async (values, { setErrors }) => {
                try {
                    const { data } = await axios.post<ApiResponse>(
                        "/calculate",
                        values
                    );

                    onSubmit(data.result);
                } catch (e: unknown) {
                    setErrors({ operation: get(e, "response.data.error") });
                }
            }}
        >
            {({ handleSubmit, isSubmitting }) => (
                <form onSubmit={handleSubmit}>
                    <div className="row g-5">
                        <div className="col-md-8">
                            <div className="form-floating">
                                <Field
                                    id="operation-fc"
                                    type="operation"
                                    name="operation"
                                    placeholder="1 + 1"
                                    className="form-control"
                                />
                                <label
                                    htmlFor="operation"
                                    className="form-label"
                                >
                                    Something to calculate
                                </label>
                            </div>
                            <ErrorMessage
                                name="operation"
                                className="invalid-feedback d-block"
                                component="div"
                            />
                        </div>
                        <div className="col-md-4">
                            <button
                                type="submit"
                                disabled={isSubmitting}
                                className="btn btn-primary"
                            >
                                {isSubmitting ? (
                                    <div
                                        className="spinner-border text-primary"
                                        role="status"
                                    >
                                        <span className="visually-hidden">
                                            Loading...
                                        </span>
                                    </div>
                                ) : (
                                    "Calculate"
                                )}
                            </button>
                        </div>
                    </div>
                </form>
            )}
        </Formik>
    );
};

export default Form;
