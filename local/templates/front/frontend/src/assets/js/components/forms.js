import IMask from "imask";
import JustValidate from "just-validate";

document.addEventListener("DOMContentLoaded", () => {
    // const phoneFields = document.querySelectorAll("input[type=tel]");
    // if (phoneFields) {
    //     phoneFields.forEach((field) => {
    //        IMask(field, {
    //           lazy: true,
    //           mask: "+{7} (000) 000-00-00",
    //           prepare: function (appended, masked) {
    //              if (appended === "8" && masked.value === "") {
    //                 return "+7";
    //              }
    //              return appended;
    //           },
    //        });
    //     });
    // }

    const requestForm = document.querySelector("[data-request-form]");
    const validationFormConfig = {
        errorFieldCssClass: "input--invalid",
        errorLabelStyle: {},
    };

    if (requestForm) {
        const validate = new JustValidate(requestForm, validationFormConfig);
        const actionUrl = requestForm.getAttribute("action");
        const formBase = document.querySelector("[data-request-form-base]");
        const formSuccess = document.querySelector("[data-request-form-success]");
        const formReset = document.querySelector("[data-request-form-reset]");
        const buttonSubmit = requestForm.querySelector("button[type=submit]");
        const fields = requestForm.querySelectorAll("input");

        // Расширенные параметры валидации для всех типов полей
        const fieldValidateParams = {
            // Обычные поля (default форма)
            name: [
                {
                    rule: "required",
                    errorMessage: "Обязательное поле",
                },
                {
                    rule: "minLength",
                    value: 2,
                    errorMessage: "Значение слишком короткое, минимум 2 символа",
                },
                {
                    rule: "maxLength",
                    value: 50,
                    errorMessage: "Значение слишком длинное, максимум 50 символов",
                },
            ],

            link: [
                {
                    rule: "required",
                    errorMessage: "Обязательное поле",
                },
                {
                    rule: "minLength",
                    value: 3,
                    errorMessage: "Ссылка слишком короткая",
                },
            ],

            connect: [
                {
                    rule: "required",
                    errorMessage: "Обязательное поле",
                },
                {
                    rule: "minLength",
                    value: 3,
                    errorMessage: "Способ связи слишком короткий",
                },
            ],

            // Новые поля для формы контактов
            address: [
                {
                    rule: "required",
                    errorMessage: "Обязательное поле",
                },
                {
                    rule: "minLength",
                    value: 3,
                    errorMessage: "Адрес сайта слишком короткий",
                },
            ],

            description: [
                {
                    rule: "required",
                    errorMessage: "Обязательное поле",
                },
                {
                    rule: "minLength",
                    value: 10,
                    errorMessage: "Описание слишком короткое, минимум 10 символов",
                },
                {
                    rule: "maxLength",
                    value: 500,
                    errorMessage: "Описание слишком длинное, максимум 500 символов",
                },
            ],

            expectation: [
                {
                    rule: "required",
                    errorMessage: "Обязательное поле",
                },
                {
                    rule: "minLength",
                    value: 5,
                    errorMessage: "Ожидания слишком короткие, минимум 5 символов",
                },
                {
                    rule: "maxLength",
                    value: 300,
                    errorMessage: "Ожидания слишком длинные, максимум 300 символов",
                },
            ],

            // Чекбоксы
            agreement: [
                {
                    rule: "required",
                    errorMessage: "Необходимо согласие на обработку данных",
                    errorFieldCssClass: ["checkbox--invalid"],
                }
            ],

            personal: [
                {
                    rule: "required",
                    errorMessage: "Необходимо согласие на обработку персональных данных",
                    errorFieldCssClass: ["checkbox--invalid"],
                },
            ]
        };

        const defaultValidateParams = [
            {
                rule: "required",
                errorMessage: "Обязательное поле",
            }
        ];

        // Добавляем валидацию для всех обязательных полей
        fields.forEach((field) => {
            if (field.required && field.name) {
                validate.addField(
                    `[name="${field.name}"]`,
                    fieldValidateParams[field.name] || defaultValidateParams
                );
            }

            field.addEventListener("input", () => {
                formCheck(requestForm);
            })
        });

        validate.onSuccess(() => {
            const formData = new FormData(requestForm);
            formData.append("form", "callbackForm");
            const plainFormData = Object.fromEntries(formData.entries());

            fetch(actionUrl, formSendConfig(plainFormData))
                .then(response => {
                    if (response.ok) {
                        formBase.dataset.requestFormBase = "";
                        formSuccess.dataset.requestFormSuccess = "active";
                    } else {
                        console.error('Ошибка отправки формы:', response.status);
                    }
                })
                .catch(error => {
                    console.error('Ошибка сети:', error);
                });
        });

        formReset.addEventListener("click", () => {
            requestForm.reset();
            validate.refresh(); // Сбрасываем состояние валидации
            formBase.dataset.requestFormBase = "active";
            formSuccess.dataset.requestFormSuccess = "";
            buttonSubmit.setAttribute("disabled", "true");
        })
    }
});

function formSendConfig(plainFormData) {
    return {
        method: "POST",
        headers: {
            "Content-Type": "application/json;charset=utf-8",
        },
        body: JSON.stringify(plainFormData),
    };
}

function formCheck(form) {
    const buttonSubmit = form.querySelector("button[type=submit]");
    const fieldRequiredList = Array.from(form.querySelectorAll('[required]'));
    const isNotValid = fieldRequiredList.find((field) => !field.checkValidity());

    buttonSubmit.disabled = isNotValid;
}