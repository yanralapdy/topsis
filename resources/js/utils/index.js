import dayjs from "dayjs";

export const RenderErrors = (err, errors) => {
    for (const key in err) {
        if (key) {
            errors.value[key] = err[key];
        }
    }
};

export const CapitalizeFirstLetterOfEachWord = (str) => {
    if (typeof str !== "string") return str;
    return str.replace(/\b\w/g, (l) => l.toUpperCase());
};

export const DateTimeToDate = (dateTime) => {
    // to yyyy-mm-dd
    if (dateTime) {
        return dateTime.split("T")[0];
    }

    return dateTime;
};

export const DateTimeToTime = (dateTime) => {
    if (dateTime) {
        const date = new Date(dateTime);
        return date.toLocaleTimeString("en-US", {
            hour: "2-digit",
            minute: "2-digit",
        });
    }

    return dateTime;
};

export const DateTimeToFormat = (dateTime, format = "DD MMMM YYYY") => {
    if (dateTime) {
        return dayjs(dateTime).format(format);
    }

    return dateTime;
};

export const CheckLengthOfEachWord = (str, maxLength = 40) => {
    const words = str.split(" ");
    let isLonger = false;
    words.map((word) => {
        if (word.length > maxLength) {
            isLonger = true;
        }
    });

    return isLonger;
};
